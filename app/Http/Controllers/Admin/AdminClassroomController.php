<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Exception;
use App\Models\{ClassroomAssignment, ClassroomChapter, ClassroomQuestion, ClassroomCourse, ClassroomSection};
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\{Storage, Validator};
use Illuminate\View\View;

class AdminClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $company = request()->input('c');
        $companyName = $company ? __('general.company-list.' . $company) : '';
        $courses = ClassroomCourse::where('company', $company)->orderBy('subject')->orderBy('name')->withCount('chapters')->get();
        return view('admin.classrooms.classroom-index', compact('company', 'companyName', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $classroom = new ClassroomCourse();
        $classroom->company = request()->input('c');
        $users = User::where('is_admin', 0)->pluck('name', 'id')->toArray();
        return view('admin.classrooms.classroom-edit', compact('classroom', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            's3_path' => 'nullable|file|mimes:pdf',
            'image_path' => 'nullable|image|mimes:jpeg,bmp,png',
        ]);
        if ($id = request()->input('id')) {
            $classroomCourse = ClassroomCourse::find($id);
            session()->flash('alert-success', 'Course Updated');
        } else {
            $classroomCourse = new ClassroomCourse();
            $classroomCourse->company = $request->input('company');
            session()->flash('alert-success', 'New Course Created');
        }
        $classroomCourse->name = $request->input('name');
        $classroomCourse->subject = $request->input('new_subject') ? $request->input('new_subject') : $request->input('subject');

        if ($request->hasFile('s3_path')) {
            if (isset($s3_path)) {
                Storage::delete($s3_path);
            }

            $pathFile = fileUpload('s3_path', ClassroomCourse::$s3PathLocation, true);
            $classroomCourse->s3_path = $pathFile;
        }

        if ($request->hasFile('image_path')) {
            if (isset($image_path)) {
                Storage::delete($image_path);
            }
            $imageFile = fileUpload('image_path', ClassroomCourse::$imagePathLocation);
            $classroomCourse->image_path = $imageFile;
        }
        $classroomCourse->save();
        // delete old users
        foreach ($request->input('deleteList', []) AS $key => $val) {
            if ($val) {
                ClassroomAssignment::find($val)->delete();
            }
        }

        // add new users
        foreach ($request->input('userList', []) AS $key => $val) {
            ClassroomAssignment::create([
                'classroom_course_id' => $classroomCourse->id,
                'user_id' => $val
            ]);
        }
        return redirect()->route('admin.classroom.index', ['c' => $classroomCourse->company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ClassroomCourse $classroom
     *
     * @return Factory|View
     */
    public function edit(ClassroomCourse $classroom)
    {
        $userIDs = $classroom->assignments()->pluck('user_id');
        $users = User::selectRaw('id, name')->whereNotIn('id', $userIDs)->orderBy('name')->orderBy('name')->pluck('name', 'id')->toArray();
        return view('admin.classrooms.classroom-edit', compact('classroom', 'users'));
    }

    /**
     * @param User $user
     * @param ClassroomCourse $course
     *
     * @return Factory|View
     */
    public function viewCourseUserResults(User $user, ClassroomCourse $course)
    {
        $chapters = $course->chapters()->with('questionsInOrder')->get();
        return view('admin.classrooms.user-course', compact('user', 'course', 'chapters'));
    }

    /**
     * @param User $user
     * @param ClassroomChapter $chapter
     *
     * @return Factory|View
     */
    public function viewChapterResults(User $user, ClassroomChapter $chapter)
    {
        return view('admin.classrooms.user-answers', compact('user', 'chapter'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ClassroomCourse $classroom
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy (ClassroomCourse $classroom)
    {
        foreach ($classroom->chapters AS $chapter) {
            $chapter->questions()->delete();
        }
        $classroom->chapters()->delete();
        $classroom->delete();
        return response()->json(['success' => true]);
    }
    /**
     * @param ClassroomCourse $course
     *
     * @return Factory|View
     */
    public function chapters(ClassroomCourse $course)
    {
        return view('admin.classrooms.chapters-index', compact('course'));
    }

    /**
     * @param ClassroomCourse $course
     *
     * @return Factory|View
     */
    public function createChapter(ClassroomCourse $course)
    {
        $chapter = new ClassroomChapter();
        $chapter->classroom_course_id = $course->id;
        return view('admin.classrooms.chapters-edit', compact('chapter', 'course'));
    }

    /**
     * @param ClassroomChapter $chapter
     *
     * @return Factory|View
     */
    public function editChapter(ClassroomChapter $chapter)
    {
        $sections = $chapter->classroomSections()->pluck('orderval', 'section_name')->toArray();
        $course = $chapter->classroomCourse;

        return view('admin.classrooms.chapters-edit', compact('chapter', 'course', 'sections'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function storeChapter(Request $request)
    {
        if ($id = $request->input('id')) {
            $chapter = ClassroomChapter::find($id);
            session()->flash('alert-success', 'Chapter Updated');
        } else {
            $chapter = new ClassroomChapter();
            $chapter->classroom_course_id = $request->input('classroom_course_id');
            session()->flash('alert-success', 'Chapter Created');
        }

        $chapter->chapter_name = $request->input('chapter_name');
        $chapter->instructions = $request->input('instructions');

        if ($request->hasFile('s3_path')) {
            if (isset($s3_path)) {
                Storage::delete($s3_path);
            }
            $chapterFile = fileUpload('s3_path', ClassroomChapter::$chapterPathLocation, true);
            $chapter->s3_path = $chapterFile;
        }
        $chapter->save();
        return redirect()->route('admin.classroom.chapter.list', $chapter->classroom_course_id);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function updateChapterOrder(Request $request)
    {
        foreach ($request->input('orderval', []) AS $id => $val) {
            ClassroomChapter::find($id)->update(['orderval' => $val]);
        }
        session()->flash('alert-success', 'Order Updated');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param ClassroomChapter $chapter
     *
     * @return Factory|View
     */
    public function addQuestion(Request $request, ClassroomChapter $chapter)
    {
        $question = new ClassroomQuestion();
        $question->question_type = $request->input('question_type');
        $question->questionsText = [];
        $sections = $this->_sections($chapter->id);
        $sectionNextVal = $this->_nextSectionVal($chapter->id);
        return view('admin.classrooms.question-add', compact('question', 'chapter', 'sections', 'sectionNextVal'));
    }

    /**
     * @param int $chapterID
     *
     * @return mixed
     */
    private function _sections($chapterID)
    {
        return ClassroomSection::selectRaw('CONCAT(orderval,") ",section_name) AS section, id')->where('classroom_chapter_id', $chapterID)->orderBy('orderval')
            ->pluck('section', 'id')->toArray();
    }

    /**
     * @param int $chapterID
     *
     * @return int
     */
    private function _nextSectionVal($chapterID)
    {
        return ClassroomSection::where('classroom_chapter_id', $chapterID)->max('orderval') ?? 1;
    }

    /**
     * @param Request $request
     * @param int $chapterID
     *
     * @return RedirectResponse
     */
    public function saveQuestion(Request $request, $chapterID)
    {
        $input = $request->only(['question', 'classroom_section_id', 'question_type']);

        if ($input['question_type'] == 'textbox') {
            $input['questions'] = json_encode(['answers' => $request->input('answer')]);
        } else {
            $input['questions'] = json_encode([
                'answers' => $request->input('buttons', null),
                'questions' => $request->input('questionsText', null),
            ]);
        }

        // create new section
        if ($newSection = request()->input('new_section')) {

            // don't allow for a duplicate section
            $orderval = $request->input('section_order');
            $orderCheck = ClassroomSection::where('classroom_chapter_id', $chapterID)->where('orderval', $orderval)->first();
            if ($orderCheck) {
                $validator = Validator::make([], []);
                $validator->getMessageBag()->add('section_order', 'Order Value Must Be Unique');
                $message = $validator->errors();
                return redirect()->back()->withErrors($message)->withInput();
            }

            // create new section
            $section = ClassroomSection::create([
                'classroom_chapter_id' => $chapterID,
                'section_name' => $request->input('new_section'),
                'orderval' => $orderval
            ]);
            $input['classroom_section_id'] = $section->id;
        } else {
            $section = ClassroomSection::find($input['classroom_section_id']);
        }

        // update section name
        $input['section'] = $section->section_name;

        if ($id = $request->input('id')) {
            $question = ClassroomQuestion::find($id);
            $question->update($input);
        } else {
            $input['orderval'] = (ClassroomQuestion::where('classroom_chapter_id', $chapterID)->max('orderval') ?? 0) + 1;
            $input['classroom_chapter_id'] = $chapterID;
            $question = ClassroomQuestion::create($input);
        }
        return redirect()->route('admin.classroom.chapter.edit', $chapterID);
    }

    /**
     * @param ClassroomQuestion $question
     *
     * @return Factory|View
     */
    public function editQuestion(ClassroomQuestion $question)
    {
        $chapter = $question->classroomChapter;
        $answers = json_decode($question->questions);
        $question->audio = $answers->audio ?? null;
        $question->questionsText = $answers->questions ?? [];
        $question->answers = $answers->answers ?? null;
        $sections = $this->_sections($chapter->id);
        $sectionNextVal = $this->_nextSectionVal($chapter->id);
        return view('admin.classrooms.question-add', compact('question', 'chapter', 'sections', 'sectionNextVal'));
    }

    /**
     * @param ClassroomQuestion $question
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteQuestion(ClassroomQuestion $question)
    {
        // count questions left in the section, and delete if this is the only one left
        if (ClassroomQuestion::where('classroom_section_id', $question->classroom_section_id)->count() == 1) {
            ClassroomSection::where('id', $question->classroom_section_id)->delete();
        }
        $question->delete();
        return response()->json(['success' => true]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function updateQuestionOrder(Request $request)
    {
        foreach ($request->input('orderval', []) AS $id => $val) {
            ClassroomQuestion::find($id)->update(['orderval' => $val]);
        }
        session()->flash('alert-success', 'Order Updated');
        return redirect()->back();
    }
}
