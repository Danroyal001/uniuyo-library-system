<div class="container">
    <div class="tab-buttons">
        <button class="tab-btn {{ last(request()->segments()) === 'new' ? 'active' : '' }}" content-id="home"
            onclick="loadResults('new')">
            New Students
        </button>
        <button class="tab-btn {{ last(request()->segments()) === 'approved' ? 'active' : '' }}" content-id="services"
            onclick="loadResults('approved', 'approved-table')">
            Approved Students
        </button>
        <button class="tab-btn {{ last(request()->segments()) === 'rejected' ? 'active' : '' }}" content-id="contact"
            onclick="loadResults('rejected', 'rejected-table')">
            Rejected Students
        </button>
        <button class="tab-btn {{ last(request()->segments()) === 'blocked' ? 'active' : '' }}" content-id="about"
            onclick="loadResults('blocked', 'blocked-table')">
            Blocked Students
        </button>
    </div>
    <div class="tab-contents">
        <div class="content {{ last(request()->segments()) === 'new' ? 'show' : '' }} " id="home">
            <img src="{{ asset('new.png') }}" alt="">
            <div class="content-info">
                <h1 class="content-title">
                    All New Students
                </h1>
                @include('panel.flags.new')
            </div>
        </div>
        <div class="content {{ last(request()->segments()) === 'approved' ? 'show' : '' }}" id="services">
            <img src="{{ asset('approval.png') }}" alt="">
            <div class="content-info">
                <h1 class="content-title">
                    All Approved Students
                </h1>
                @include('panel.flags.approved')
            </div>
        </div>
        <div class="content {{ last(request()->segments()) === 'rejected' ? 'show' : '' }}" id="contact">
            <img src="{{ asset('rejected.png') }}" alt="">
            <div class="content-info">
                <h1 class="content-title">
                    All Rejected Students
                </h1>
                @include('panel.flags.rejected')
            </div>
        </div>

        <div class="content {{ last(request()->segments()) === 'blocked' ? 'show' : '' }}" id="about">
            <img src="{{ asset('block.png') }}" alt="" width="220">
            <div class="content-info">
                <h1 class="content-title">
                    All Blocked Students
                </h1>
                @include('panel.flags.blocked')
            </div>
        </div>
    </div>
    </di>
</div>
