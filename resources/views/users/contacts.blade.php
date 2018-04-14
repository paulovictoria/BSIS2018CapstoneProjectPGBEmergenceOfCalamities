@extends('layouts.home')
  @section('title', 'Contacts - PDRRMO Bulacan')
  @section('details')
    <div class="mdl-grid text-padding">
      <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
        <p class="mdl-typography--text-center mdl-typography--display-2 mdl-color-text--white">The Developers Team</p>
      </div> 
    </div>
    <div class="mdl-grid margin">
      <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone hvr-float">
        <div class="mdl-cell mdl-cell--12-col mdl-color--blue-grey-50 contact-holder mdl-shadow--16dp">
          <div class="pic-holder-gieselle mdl-color--white mdl-shadow--2dp">

          </div>
          <div class="mdl-typography--text-center mdl-typography--headline">
            Gieselle Gan
          </div>
          <div class="mdl-typography--text-center mdl-typography--subhead">
            Documentator / Designer
          </div>
          <div class="mdl-typography--text-center mdl-typography--subhead">
            <a href="mailto:elleseigan@gmail.com" class="link-icons"><i class="fab fa-google report-modal--icon"></i></a>
            <a href="https://goo.gl/1dTxLP" class="link-icons"><i class="fab fa-facebook-square report-modal--icon"></i></a>
            <a href="https://goo.gl/x54MvS" class="link-icons"><i class="fab fa-github report-modal--icon"></i></a>
          </div>
        </div>
      </div>
      <!--rannie-->
      <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone hvr-float">
        <div class="mdl-cell mdl-cell--12-col mdl-color--blue-grey-50 contact-holder mdl-shadow--16dp">
          <div class="pic-holder-rannie mdl-color--white mdl-shadow--2dp">

          </div>
          <div class="mdl-typography--text-center mdl-typography--headline">
            Rannie Ollit
          </div>
          <div class="mdl-typography--text-center mdl-typography--subhead">
            Software Developer / Team Lead
          </div>
          <div class="mdl-typography--text-center mdl-typography--subhead">
            <a href="mailto:einnar82@gmail.com" class="link-icons"><i class="fab fa-google report-modal--icon"></i></a>
            <a href="https://goo.gl/wCUWi2" class="link-icons"><i class="fab fa-facebook-square report-modal--icon"></i></a>
            <a href="https://goo.gl/vcJNRz" class="link-icons"><i class="fab fa-github report-modal--icon"></i></a>
          </div>
        </div>
      </div>
      <!--redel-->
      <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone hvr-float">
        <div class="mdl-cell mdl-cell--12-col mdl-color--blue-grey-50 contact-holder mdl-shadow--16dp">
          <div class="pic-holder-redel mdl-color--white mdl-shadow--2dp">

          </div>
          <div class="mdl-typography--text-center mdl-typography--headline">
            Redel Santiago
          </div>
          <div class="mdl-typography--text-center mdl-typography--subhead">
            Documentator / Researcher
          </div>
          <div class="mdl-typography--text-center mdl-typography--subhead">
            <a href="mailto:mailto:redelsantiago21@yaho­o.com" class="link-icons"><i class="fab fa-google report-modal--icon"></i></a>
            <a href="https://goo.gl/EaANzZ" class="link-icons"><i class="fab fa-facebook-square report-modal--icon"></i></a>
            <a href="https://goo.gl/yae8X6" class="link-icons"><i class="fab fa-github report-modal--icon"></i></a>
          </div>
        </div>
      </div>
    </div>
  @endsection
  @section('scripts')
    <script async defer src="{{URL::to('js/home.js')}}" type="text/javascript"></script>
  @endsection