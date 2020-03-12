
 <!-- Bootstrap core JavaScript -->
  <script src="{{asset('js/jquery.min.js')}}"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('js/bootstrap.min.js')}}" ></script> 
  <!-- Plugin JavaScript -->
  <script src="{{asset('js/jquery.easing.min.js')}}"></script>
  <!-- Custom scripts for this template -->
  <script src="{{asset('js/agency.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="{{asset('js/custom_function_admin.js')}}"></script>
<script>
$(document).ready(function() {
    $("#active_contracts_span").click(function() {
            $("#active_contracts_span").addClass("active-span");
            $("#old_contracts_span").removeClass("active-span");
            $("#active_contracts_div").show();
            $("#old_contracts_div").hide();
        
    });
    $("#old_contracts_span").click(function() {
            $("#old_contracts_span").addClass("active-span");
            $("#active_contracts_span").removeClass("active-span");
            $("#active_contracts_agreediv").hide();
            $("#old_contracts_agreediv").show();
        
    });
    /********************************/
    $("#active_contracts_agree").click(function() {
            $("#active_contracts_agree").addClass("active-span");
            $("#old_contracts_agree").removeClass("active-span");
            $("#active_contracts_agreediv").show();
            $("#old_contracts_agreediv").hide();
        
    });
    $("#old_contracts_agree").click(function() {
            $("#old_contracts_agree").addClass("active-span");
            $("#active_contracts_agree").removeClass("active-span");
            $("#active_contracts_agreediv").hide();
            $("#old_contracts_agreediv").show();
    });
    /********************************/
    $("#pending_span").click(function() {
            $("#pending_span").addClass("active-span");
            $("#historical_span").removeClass("active-span");
            $("#pending_div").show();
            $("#historical_div").hide();
        
    });
    $("#historical_span").click(function() {
            $("#historical_span").addClass("active-span");
            $("#pending_span").removeClass("active-span");
            $("#pending_div").hide();
            $("#historical_div").show();
    });
    
    /********************************/
    $("#current_span").click(function() {
            $("#current_span").addClass("active-span");
            $("#archived_span").removeClass("active-span");
            $("#current-div").show();
            $("#archived-div").hide();
        
    });
    $("#archived_span").click(function() {
            $("#archived_span").addClass("active-span");
            $("#current_span").removeClass("active-span");
            $("#current-div").hide();
            $("#archived-div").show();
    });
    
    /********************************/
    $("#current_courses_span").click(function() {
            $("#current_courses_span").addClass("active-span");
            $("#historical_courses_span").removeClass("active-span");
            $("#current-courses-div").show();
            $("#historical-courses-div").hide();
        
    });
    $("#historical_courses_span").click(function() {
            $("#current_courses_span").addClass("active-span");
            $("#historical_courses_span").removeClass("active-span");
            $("#current-courses-div").hide();
            $("#historical-courses-div").show();
    });
    $(".enter-btn").click(function() {
            
            $(".courses-div").hide();
            $("#courses_details_div").show();
    });



     /********************************/
    $("#active_mileage_span").click(function() {
            $("#active_mileage_span").addClass("active-span");
            $("#old_mileage_span").removeClass("active-span");
            $("#active_mileage_div").show();
            $("#active_mileage_div").hide();
        
    });
    $("#old_mileage_span").click(function() {
       
            $("#old_mileage_span").addClass("active-span");
            $("#active_mileage_span").removeClass("active-span");
            $("#active_mileage_div").hide();
            $("#old_mileage_div").show();
    });

 
 /********************************/
    $("#active_ticket_span").click(function() {
            $("#active_ticket_span").addClass("active-span");
            $("#complited_ticket_span").removeClass("active-span");
            $("#active_ticket_div").show();
            $("#complited_ticket_div").hide();
        
    });
    $("#complited_ticket_span").click(function() {
            $("#complited_ticket_span").addClass("active-span");
            $("#active_ticket_span").removeClass("active-span");
            $("#active_ticket_div").hide();
            $("#complited_ticket_div").show();
    });
 



});


</script>
<script type="text/javascript">
    setTimeout(function(){
        $(".all_errors").fadeOut( "slow");
    }, 3000);
</script>


@if (session('message'))
    <script>
        $(document).ready(function(){
            swal("{{Session::get('message')}}","", "success");
        });
    </script>
@endif
@if (session('error'))
    <script>
        $(document).ready(function(){
            swal("{{Session::get('error')}}","", "danger");
        });
    </script>
@endif
@if (session('messagemileage'))
    <script>
        $(document).ready(function(){
            swal("{{Session::get('messagemileage')}}","", "success");
        });
    </script>
@endif


</body>

</html>