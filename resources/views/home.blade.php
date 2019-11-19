@extends('layouts.app')

@section('content')

<div class="row card-deck">
  <div class="col-4">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="lead col-8">
            Categories
          </div>
          <div class="col-4">
            <a href="/matter/create?operation=new" data-target="#ajaxModal" data-toggle="modal" data-size="modal-sm" class="btn btn-primary float-right" title="Create Matter">Create matter</a>
          </div>
        </div>
        <div class="row font-weight-bold">
          <div class="col-8">
            Category
          </div>
          <div class="col-3">
            Count
          </div>
          <div class="col-1">
          </div>
        </div>
      </div>

      <div class="card-body pt-1" style="min-height: 80px;">
        @foreach ($categories as $group)
        <div class="row reveal-hidden">
          <div class="col-8">
            <a href="/matter?Cat={{ $group->category_code }}">{{ $group->category }}</a>
          </div>
          <div class="col-3">
            {{ $group->total }}
          </div>
          <div class="col-1">
            <a class="badge badge-primary hidden-action" href="/matter/create?operation=new&category={{$group->category_code}}" data-target="#ajaxModal" title="Create new {{ $group->category }}" data-toggle="modal" data-size="modal-sm">
              &plus;
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="card mt-1">
      <div class="card-header">
        <div class="row">
          <div class="lead col-8">
            Users tasks
          </div>
          <div class="col-4">
            <button class="btn btn-light text-light" disabled>I</button> {{--  This invisible button is only for improving the layout! --}}
          </div>
        </div>
        <div class="row font-weight-bold">
          <div class="col-6">
            User
          </div>
          <div class="col-3">
            Open
          </div>
          <div class="col-3">
            Hottest
          </div>
        </div>
      </div>

      <div class="card-body pt-1" style="min-height: 80px;">
        @foreach ($taskscount as $group)
        @if ($group->no_of_tasks > 0)
        <div class="row">
          <div class="col-6">
            <a href="/home?user_dashboard={{ $group->login }}">{{ $group->login }}</a>
          </div>
          <div class="col-3">
            {{ $group->no_of_tasks }}
          </div>
          @if ($group->urgent_date < date('Y-m-d'))
          <div class="col-3 text-danger">
            {{ $group->urgent_date }}
          </div>
          @elseif ($group->urgent_date < date('Y-m-d', strtotime("+1 week")))
          <div class="col-3">
            <font color="purple">{{ $group->urgent_date }}</font>
          </div>
          @else
          <div class="col-3">
            {{ $group->urgent_date }}
          </div>
          @endif
        </div>
        @endif
      @endforeach
      </div>
    </div>
  </div>
  <div class="col-8" id="filter">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="lead col-3">
            Open tasks
          </div>
          <div class="col-5">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              <label class="btn btn-info active">
                <input type="radio" name="my_tasks" id="alltasks" value="0">Everyone
              </label>
              <label class="btn btn-info">
                <input type="radio" name="my_tasks" id="mytasks" value="1">{{ Auth::user()->login }}
              </label>
            </div>
          </div>
          <div class="col-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <button class="btn btn-outline-primary" type="button" id="clear-open-tasks">Clear selected on</button>
              </div>
              <input type="date" class="form-control" name="datetaskcleardate" id="taskcleardate">
            </div>
          </div>
        </div>
        <div class="row font-weight-bold">
          <div class="col-6">
            Tasks
          </div>
          <div class="col-3">
            Matter
          </div>
          <div class="col-2">
            Due date
          </div>
          <div class="col-1">
            Clear
          </div>
        </div>
      </div>
      <div class="card-body pt-1" id="tasklist" style="min-height: 80px;">
        @isset($tasks)
        @foreach ($tasks as $task)
        <div class="row">
          <div class="col-6">
            <a href="/matter/{{ $task->matter_id }}/tasks" data-toggle="modal" data-target="#ajaxModal" data-size="modal-lg" data-resource="/task/" title="All tasks">
              {{ $task->name }}{{ $task->detail ? " - ".$task->detail : "" }}
            </a>
          </div>
          <div class="col-3">
            <a href="/matter/{{ $task->matter_id }}">
              {{ $task->uid }}
            </a>
          </div>
          @if ($task->due_date < date('Y-m-d'))
          <div class="col-2 text-danger">
            {{ date_format(date_create($task->due_date), 'd/m/Y') }}
          </div>
          @elseif ($task->due_date < date('Y-m-d', strtotime("+1 week")))
          <div class="col-2">
            <font color="purple">{{ date_format(date_create($task->due_date), 'd/m/Y') }}</font>
          </div>
          @else
          <div class="col-2">
            {{ date_format(date_create($task->due_date), 'd/m/Y') }}
          </div>
          @endif
          <div class="col-1">
            <input id="{{ $task->id }}" class="clear-open-task" type="checkbox">
          </div>
        </div>
        @endforeach
        @else
        <div class="row text-danger">
          The list is empty
        </div>
      @endisset
      </div>
    </div>
    <div class="card mt-1">
      <div class="card-header">
        <div class="row">
          <div class="lead col-3">
            Open renewals
          </div>
          <div class="col-5">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              <label class="btn btn-info active">
                <input type="radio" name="my_renewals" id="allrenewals" value="0">Everyone
              </label>
              <label class="btn btn-info">
                <input type="radio" name="my_renewals" id="myrenewals" value="1">{{ Auth::user()->login }}
              </label>
            </div>
          </div>
          <div class="col-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <button class="btn btn-outline-primary" type="button" id="clear-ren-tasks">Clear selected on</button>
              </div>
              <input type="date" class="form-control" name="renewalcleardate" id="renewalcleardate">
            </div>
          </div>
        </div>
        <div class="row font-weight-bold">
          <div class="col-6">
            Renewals
          </div>
          <div class="col-3">
            Matter
          </div>
          <div class="col-2">
            Due date
          </div>
          <div class="col-1">
            Clear
          </div>
        </div>
      </div>

      <div class="card-body pt-1" id="renewallist" style="min-height: 80px;">
        @isset($renewals)
        @foreach ($renewals as $task)
        <div class="row">
          <div class="col-6">
            <a href="/matter/{{ $task->matter_id }}/renewals" data-toggle="modal" data-target="#ajaxModal" title="All tasks" data-size="modal-lg">
              {{ $task->detail }}
            </a>
          </div>
          <div class="col-3">
            <a href="/matter/{{ $task->matter_id }}">
              {{ $task->uid }}
            </a>
          </div>
          @if ($task->due_date < date('Y-m-d'))
          <div class="col-2 text-danger">
            {{ date_format(date_create($task->due_date), 'd/m/Y') }}
          </div>
          @elseif ($task->due_date < date('Y-m-d', strtotime("+1 week")))
          <div class="col-2">
            <font color="purple">{{ date_format(date_create($task->due_date), 'd/m/Y') }}</font>
          </div>
          @else
          <div class="col-2">
            {{ date_format(date_create($task->due_date), 'd/m/Y') }}
          </div>
          @endif
          <div class="col-1">
            <input id="{{ $task->id }}" class="clear-ren-task" type="checkbox">
          </div>
        </div>
        @endforeach
        @else
        <div class="row text-danger">
          The list is empty
        </div>
      @endisset
      </div>
    </div>
  </div>
</div>

@if (session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@endif

@stop

@section('script')

@include('home-js')

@stop
