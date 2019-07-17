@extends('layouts.portal')

@section('title')
 UI Elements
@endsection

@section('styles')
<style>
 .list-group {
  --spacing: 1.5rem;
  --width: 115px;
  --bgColor: #fff;
  --altColor: #000;
  margin-top: calc(var(--spacing) * 2);
  margin-bottom: calc(var(--spacing) * 2);
  background-color: var(--altColor);
  position: relative;
 }
 .list-group:after {
  width: calc(100% - var(--width));
  background-color: var(--bgColor);
  height: calc(100% + (var(--spacing) * 2));
  margin-top: calc(var(--spacing) * -1);
  -moz-box-shadow: 0px 0px 13px -2px rgba(0,0,0,.5);
  -webkit-box-shadow: 0px 0px 13px -2px rgba(0,0,0,.5);
  box-shadow: 0px 0px 13px -2px rgba(0,0,0,.5);
  content: '';
  position: absolute;
  display: block;
 }
 .list-group > .list-group-item {
  margin-right: var(--spacing);
  z-index: 2;
  background-color: transparent;
  border-color: rgba(146,146,146,.15);
 }
 .list-group > .list-group-item:not(:first-child):not(:last-child):before {
  background-color: var(--bgColor);
  width: calc(100% - var(--width));
  content: '';
  left: 0;
  top: 0;
  z-index: -1;
  position: absolute;
  display: block;
  height: 100%;
 }
 .list-group > .list-group-item:first-child {
  border-top: 0;
 }
 .list-group > .list-group-item:first-child, .list-group > .list-group-item:last-child {
  background-color: var(--altColor);
  z-index: 3;
  -moz-box-shadow: 0px 0px 10px -1px rgba(0,0,0,.5);
  -webkit-box-shadow: 0px 0px 10px -1px rgba(0,0,0,.5);
  box-shadow: 0px 0px 10px -1px rgba(0,0,0,.5);
 }
</style>
@endsection

@section('content')
 <div>
  <pre>new dashboards</pre>
  <h4>Patient/Caregiver</h4>
   redirect to RID page; create new blade template with EAC logo, no portal links, ability to contact EAC for assistance
  <hr />
  <h3>Pharmaceutical</h3>
   <strong class="d-block">ADMIN</strong>
   company information, drugs, requests, user groups and users
   <strong class="d-block">USER</strong>
   company information, drugs, requests assigned, assigned user group, user info
  <hr />
  <h2>Physician</h2>
   rids, avail drugs, assigned user groups, user info, report adverse effects
  <hr />
  <h1>Early Access Care</h1>
   requests, drugs, users, user groups, awaiting shipment, awaiting review, stats<br />
   56 Pharmaceutical Users in 8 Groups<br />
    -- 15 Group members in Group ABC<br />
 </div>
 <hr />
 <hr />
 <ul class="list-group list-group-flush">
  <li class="list-group-item d-flex justify-content-between align-items-center">
   <a href="#" class="text-white upper">
    Monthly Traffic <span class="fal fa-angle-down-down"></span>
   </a>
   <a href="#" class="text-white">
    <span class="fal fa-redo"></span>
   </a>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
   <span class="text-muted">Google Chrome</span>
   <span class="text-success">39.8%</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
   <span class="text-muted">Mozilla Firefox</span>
   <span class="text-info">26.9%</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
   <span class="text-muted">Internet Explorer</span>
   <span class="text-success">22.8%</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
   <span class="text-muted">Safari</span>
   <span class="text-danger">3.2%</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
   <span class="text-muted">Other</span>
   <span class="text-warning">.2%</span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-center">
   <span class="text-white">Total Result</span>
   <span class="text-white">92.9%</span>
  </li>
 </ul>

@endsection
