@extends('chat.templates.private-chat-layout')

@section('body')

  <input type="hidden" id="messageType" value="private">

  {{-- chat header --}}
  <div class="chat">
    <div class="chat-header clearfix">
      <div class="row">
        <div class="col-lg-6">
          <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
            <img src="/images/sadboi.png" alt="avatar">
          </a>
          <div class="chat-about">
            <div class="name">
              <h6 class="mb-0">{{ $u->username }}</h6>
            </div>
            <div class="status">
              @if(Cache::has('user-is-online-' . $u->id))
                <i class="fa fa-circle online"></i>
                <small class="text-success">Online</small>
              @else
                <i class="fa fa-circle offline"></i>
                <small>{{ Carbon\Carbon::parse($u->last_seen)->diffForHumans() }}</small>
              @endif
            </div>
          </div>
        </div>
      </div>
  </div>
  {{-- end chat header --}}

  {{-- chat body --}}
  <div class="chat-history" id="chat-history">
    <ul id="privateMessage">
      @foreach ($messages as $message)
        @if ($message->user_id == Auth::user()->id)
          <li class="clearfix">
            <div class="message my-message float-right">{{ $message->message }}</div>
          </li>
        @else
          <li class="clearfix">
            <div class="message other-message">{{ $message->message }}</div>                                    
          </li>
        @endif
      @endforeach
    </ul>
  </div>
  {{-- end chat body --}}

  {{-- message form --}}
  <div class="chatMessageClearfix">
    <form id="privateMessageForm">
      <input type="hidden" name="receiver_id" id="receiverId" value="{{ $u->id }}">
      <input type="hidden" name="conversation_id" id="conversationId" value="{{ $conversationId }}">
      <input type="hidden" name="user_id" id="userId" value="{{ Auth::user()->id }}">
      <input type="hidden" name="user_name" id="userName" value="{{ Auth::user()->username }}">
      <div class="input-group mb-1">
        <input type="text" name="message" id="privateMessageInput" class="form-control" placeholder="Enter text here..." autocomplete="off">                                    
        <div class="input-group-prepend">
          <button class="btn btn-primary">Send</button>
        </div>
      </div>
    </form>
  </div>
  {{-- end message form --}}

  <script src="/js/app.js"></script>
  <script>
    document.getElementById('privateMessageForm').addEventListener('submit', function() {
        document.getElementById('privateMessageInput').value = '';
    });
  </script>

@endsection