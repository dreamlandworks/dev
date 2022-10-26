<style>
.col-sm-3.mk {
    float: left;
    padding-top: 30px;
    padding-right: 14px;
}
</style>
<div class="modal-dialog modal-xl" role="document" style="max-width:1000px !important;">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold" id ="modalContactForm_userinfo">User information</h4>
        <button type="button" id="sp-modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body mx-3">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        @if($userDetails && $userDetails != '')
                        <p>UserId:&nbsp;&nbsp;&nbsp;&nbsp;{{$userDetails->id}}</p>
                        <p>First Name:&nbsp;&nbsp;&nbsp;&nbsp;{{$userDetails->fname}}</p>
                        <p>Last Name:&nbsp;&nbsp;&nbsp;&nbsp;{{$userDetails->lname}}</p>
                        <p>Mobile:&nbsp;&nbsp;&nbsp;&nbsp;{{$userDetails->mobile}}</p>
                        @endif
                        @if($users && $users != '')
                        <p>EMail:&nbsp;&nbsp;&nbsp;&nbsp;{{$users->email}}</p>
                        @endif
                        @if($SPVerifys && $SPVerifys != '')
                        <p>IDProof:&nbsp;&nbsp;&nbsp;&nbsp;{{$SPVerifys->id_card}}</p>
                        <button type="button" style="border: 0px;margin-top: 10px;" onclick="showDocument('{{asset('images/id_proof')}}/{{$SPVerifys->id_card}}')">
                            <embed id="idPreview" src="{{asset('images/id_proof')}}/{{$SPVerifys->id_card}}" width="100px" height="100px" style="margin-top:10px; "/>
                        </button>

                        @else
                        <div class="holder border border-sm shadow shadow-lg mt-5  mr-2 bg-light col-lg-8 col-md-8 col-sm-12"  >

                            <embed id="imgPreview" src="{{asset('images/id_proof/dummy.png')}}" alt="pic"style="height:150px; width:200px;" class="img-fluid"/>
                        </div>
                        @endif
                    </div>
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-5">
                        @if($spDetails && $spDetails != '[]')
                        <p>Profession:&nbsp;&nbsp;&nbsp;&nbsp;{{$spDetails['0']->name}}</p>
                        <p>Qualification:&nbsp;&nbsp;&nbsp;&nbsp;{{$spDetails['0']->qualification}}</p>
                        <p>Experience:&nbsp;&nbsp;&nbsp;&nbsp;{{$spDetails['0']->exp}}</p>
                        @endif
                        @if($address && $address != '[]')
                          <p>City:&nbsp;&nbsp;&nbsp;&nbsp;{{$address['0']->city}}</p>
                          <p>State:&nbsp;&nbsp;&nbsp;&nbsp;{{$address['0']->state}}</p>
                          <p>Country:&nbsp;&nbsp;&nbsp;&nbsp;{{$address['0']->country}}</p>
                        @endif
                        <p>Skills/Keywords:&nbsp;&nbsp;&nbsp;&nbsp;{{$skills}}</p>
                        <p>Languages:&nbsp;&nbsp;&nbsp;&nbsp;{{$languages}}</p>
                    </div>
                </div>
                  <div class="col-sm-3 mk">
                        <video width="220" height="140" controls>
                        <source src="https://elasticbeanstalk-ap-south-1-702440578175.s3.ap-south-1.amazonaws.com/videos/59_video_record_2_1654096231_744b0bd01644b31648a1.mp4" type="video/mp4">
                        video 1
                        </video>
                    </div>
                  <div class="col-sm-3 mk">
                    <video width="220" height="140" controls>
                        <source src="@if($SPVerifys){{$SPVerifys->video_record_2}} @endif" type="video/mp4">
                        video 2
                        </video>
                  </div>
                  <div class="col-sm-3 mk">
                    <video width="220" height="140" controls>
                        <source src="@if($SPVerifys){{$SPVerifys->video_record_3}} @endif" type="video/mp4">
                        video 3
                      </video>
                  </div>
                  <div class="col-sm-3 mk">
                    <video width="220" height="140" controls>
                        <source src="@if($SPVerifys){{$SPVerifys->video_record_4}} @endif" type="video/mp4">
                        video 4
                        </video>
                  </div>
            </div>
        </div>

    </div>
  </div>
