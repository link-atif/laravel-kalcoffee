@extends('layouts.homelayout.front_design')
@section('content')
  <div class="inner_pages_title">
    <div class="container">
      <div class="courses_title">
        <h6>Contact </h6>
      </div>
    </div>
  </div>
       
  <div class="container">
    <div class="contact_section">
           <div class="col-md-4">
               <div class="contact_left">
                   <h4>Let’s talk or meet us</h4>
                   <div class="map_sec">
                      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d59389.399745651506!2d39.185106042883305!3d21.51408468425585!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x263e3f4d94687baa!2sKAL%20COFFEE!5e0!3m2!1sen!2s!4v1585485465927!5m2!1sen!2s" width="350" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                   </div>
                   <div class="address_info">
                       <p><span class="span_first">Address </span> : Al-Ruwais, Jeddah 23214, <br>Saudi Arabia</p>
                       <p><span>Phone</span> : +966 12 650 3232</p>
                       <p><span>Email</span> :<a href="#">info@kalcoffee.com</a></p>
                   </div>
               </div>
           </div>
           
           <div class="col-md-8">
               <div class="contact_right">
                <h4>Write to us</h4>
                   <div class="contact_right_col">
                       <form action="{{ route('contact.queries') }}" method="post" name="frm" id="frm">{{ csrf_field() }}
                           @if($errors->any())
                              <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                  {{ $error }} <br>
                                @endforeach
                              </div>
                            @endif
                            @if(Session::has('flash_message_success'))
                              <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{!! session('flash_message_success') !!}</strong>
                              </div>
                            @endif
                           <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Entity Name">
                           </div>
                           
                           <div class="col-md-6">
                            <input type="text" name="contact_name" class="form-control" placeholder="Contact Name">
                           </div>
                           
                           <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                           </div>
                           
                           <div class="col-md-6">
                            <input type="text" name="contact" class="form-control" placeholder="Phone number">
                           </div>
                           
                           <div class="col-md-12">
                            <input type="text" class="form-control" name="note" placeholder="Notes">
                           </div>
                           
                           <div class="clearfix"></div>
                           <div class="col-md-12">
                           <div class="form_select_option_col">
                             <p>
                                 <span>Entity Age</span>
                                 <label><input type="radio" name="entity_age" value="new"> New</label>
                                 <label><input type="radio" name="entity_age" value="existing"> Existing</label>
                             </p>
                             
                             <p>
                                 <span>Dealing as </span>
                                 <label><input type="radio" name="dealing" value="cafe"> Cafe</label>
                                 <label><input type="radio" name="dealing" value="cafe and roastery"> Cafe and Roastery</label>
                             </p>
                           </div>
                           
                           <a href="javascript:" onclick="submitForm()">SUBMIT</a>
                           </div>
                           
                       </form>
                   </div>
                   
               </div>
           </div>
       </div>
  </div>
@endsection
@section('script')
 <script type="text/javascript">
   function submitForm(){
    $("#frm").submit();
   }
 </script>
@endsection