<?php

namespace App\Http\Controllers;

use App\Courses;
use App\Models\{ClassroomAnswer, ClassroomArchive, ClassroomAssignment, ClassroomChapter, ClassroomQuestion, ClassroomSection};
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmployeeClassroomController extends Controller {
    /**
     * @return Factory|View
     */
    public function courses () {
        $courses = Auth::User()->courses;
//        $courses = Courses::all();
        $activeMenu = 'classroom';
        return view('employee.classroom.employee-classroom', compact('courses', 'activeMenu'));
    }

    /**
     * @param $id
     *
     * @return Factory|View
     */
    public function chapters ($id) {
        $course = Auth::User()->courses()->where('classroom_courses.id', $id)->first();
        $alreadyCompletedChapters = $course->userArchives->pluck('classroom_chapter_id', 'classroom_chapter_id')->toArray();
        return view('employee.classroom.employee-course', compact('course', 'alreadyCompletedChapters'));
    }

    /**
     * @param ClassroomChapter $chapter
     *
     * @return Factory|View
     */
    public function takeCourse (ClassroomChapter $chapter) {
        // check that this is a valid chapter
        $check = ClassroomAssignment::where('classroom_course_id', $chapter->classroom_course_id)->where('user_id', Auth::User()->id)->first();
        if (!$check) {
            abort(401);
        }
        // save a step if QuestionID has been passed
        if ($qid = request()->input('qid', 0)) {
            $question = ClassroomQuestion::find($qid);
            $section = $question->classroomSection;
        }
        else {
            if ($sectionID = request()->input('section')) {
                $section = ClassroomSection::find($sectionID);
            }
            else {
                // find first section, if one hasn't been passed
                $section = $chapter->classroomSections()->first();
                $sectionID = $section->id;
            }
            $q = ClassroomQuestion::where('classroom_chapter_id', $chapter->id)->where('classroom_section_id', $sectionID);
            // if next ID is passed, use it
            if ($qid = request()->input('qid', 0)) {
                $q->where('id', $qid);
            }
            $question = $q->orderBy('orderval')->first();
        }
        $numQuestions = $chapter->questionsInOrder()->count();
        $count = 0;
        $break = false;
        foreach ($chapter->classroomSections()->with('classroomQuestionsOrder')->get() AS $s) {
            foreach ($s->classroomQuestionsOrder AS $item) {
                /*echo $item->id.'-';*/
                if ($item->id == $question->id) {
                    $break = true;
                    break;
                }
                $count++;
            }
            if ($break) {
                break;
            }
        }

        $progress = number_format(($count / $numQuestions) * 100, 1);
        /*        echo $count . ' - ' . $numQuestions;*/
        return view('employee.classroom.employee-take-course', compact('chapter', 'question', 'section', 'progress'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function save (Request $request) {
        $section = ClassroomSection::find(request()->input('section'));
        if (!$section) {
            abort(404);
        }

        // go through each question
        $question = ClassroomQuestion::find($request->input('qid'));
        $input = [
            'user_id'               => Auth::User()->id,
            'classroom_question_id' => $question->id,
            'classroom_chapter_id'  => $question->classroom_chapter_id
        ];
        // build answers based on question type
        if ($question->question_type == 'audio') {
            $input['answer'] = $request->input('text.' . $question->id);
        }
        elseif ($question->question_type == 'radio') {
            $input['answer'] = $request->input('text.' . $question->id, '');
        }
        elseif ($question->question_type == 'checkbox') {
            $input['answer'] = json_encode($request->input('text.' . $question->id, ''));
        }
        elseif ($question->question_type == 'textbox') {
            $input['answer'] = $request->input('text.' . $question->id);
        }
        $answer = ClassroomAnswer::where('user_id', Auth::User()->id)->where('classroom_question_id', $question->id)->first();
        if ($answer) {
            $answer->update($input);
        }
        else {
            $answer = ClassroomAnswer::create($input);
        }
        $assignment = ClassroomAssignment::where('user_id', Auth::User()->id)->where('classroom_course_id', $section->classroomChapter->classroom_course_id)->first();

        if ($request->input('stay', false)) {
            session()->flash('alert-success', 'Answer Saved');

            return redirect()->back();
        }

        // find next page / section
        $nextQuestion = ClassroomQuestion::where('classroom_section_id', $section->id)->where('orderval', '>', $question->orderval)->orderBy('orderval')->first();
        if ($nextQuestion) {
            return redirect()->route('employee.classroom.take-course', [$nextQuestion->classroom_chapter_id, 'section' => $section->id, 'qid' => $nextQuestion->id]);
        }

        // if next page isn't in the current section, go to the next section
        $nextSection = ClassroomSection::where('classroom_chapter_id', $section->classroom_chapter_id)->where('orderval', '>', $section->orderval)->orderBy('orderval')->first();
        if ($nextSection) {
            $assignment->updateProgress('chapter-' . $section->classroom_chapter_id, 'in-progress');

            return redirect()->route('employee.classroom.take-course', [$nextSection->classroom_chapter_id, 'section' => $nextSection->id]);
        }
        else {
            // otherwise, the chapter is completed
            $assignment->updateProgress('chapter-' . $section->classroom_chapter_id, 'complete');

            return redirect()->route('employee.classroom.chapters', $section->classroomChapter->classroom_course_id);
        }
    }

    /**
     * @param ClassroomChapter $chapter
     *
     * @return RedirectResponse
     */
    public function repeatChapter (ClassroomChapter $chapter) {
        // create archive
        $archive = ClassroomArchive::create(['user_id' => Auth::User()->id, 'classroom_chapter_id' => $chapter->id, 'classroom_course_id' => $chapter->classroom_course_id]);

        // associate archive ID to about-to-be-deleted answers
        $chapter->userClassroomAnswers()->update(['classroom_archive_id' => $archive->id]);
        $chapter->userClassroomAnswers()->delete();

        // update chapter status
        $assignment = ClassroomAssignment::where('user_id', Auth::User()->id)->where('classroom_course_id', $chapter->classroom_course_id)->first();
        $assignment->updateProgress('chapter-' . $chapter->id, 'start-over');

        return redirect()->route('employee.classroom.take-course', $chapter->id);
    }
}
