@extends('layouts.home')
  @section('title', 'About - PDRRMO Bulacan')
  @section('details')
  <div class="mdl-grid mdl-color--white auto-padding">
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
      <p class="mdl-typography--text-left mdl-typography--display-1">About the Project:</p>
      <p class="mdl-typography--text-justify mdl-typography--headline">
        The Web based Weather Monitoring Application and Response System for the Provincial Government of Bulacan
        is a weather monitoring application created to make the residents of Bulacan always aware and prepared in case a
        bad weather condition happens and the mediums to achieve information updates become inaccessible. It is also equipped with
        a Response System that easily locate the affected areas during calamities and accidents, making the rescue operations faster.
      </p>
    </div>
  </div>
    <div class="mdl-grid auto-padding disclaimer">
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
      <p class="mdl-typography--text-left mdl-typography--display-1">Disclaimer:</p>
      <p class="mdl-typography--text-justify mdl-typography--headline">
        All the data used in the web application is not originally from the proponents and is use only for the purpose of the Capstone Project.
        
      </p>
    </div>
  </div>
  @endsection
  @section('scripts')
    <script async defer src="{{URL::to('js/home.js')}}" type="text/javascript"></script>
  @endsection