<div class="container">
    <div class="tab-buttons">
        <button class="tab-btn {{ last(request()->segments()) === 'branch' ? 'active' : '' }}" content-id="home"
            onclick="loadResults('branch')">
            School Branch
        </button>
        <button class="tab-btn {{ last(request()->segments()) === 'category' ? 'active' : '' }}" content-id="services"
            onclick="loadResults('category', 'category-table')">
            Student Category
        </button>
        {{-- <button class="tab-btn {{ last(request()->segments()) === 'rejected' ? 'active' : '' }}" content-id="contact"
            onclick="loadResults('rejected', 'rejected-table')">
            Rejected Students
        </button>
        <button class="tab-btn {{ last(request()->segments()) === 'blocked' ? 'active' : '' }}" content-id="about"
            onclick="loadResults('blocked', 'blocked-table')">
            Blocked Students
        </button> --}}
    </div>
    <div class="tab-contents">
        <div class="content {{ last(request()->segments()) === 'branch' ? 'show' : '' }} " id="home">
            <img src="{{ asset('branch.png') }}" alt="">
            <div class="content-info">
                <h1 class="content-title">
                    All School Branches
                </h1>
                @include('panel.settings.branch')
            </div>
        </div>
        <div class="content {{ last(request()->segments()) === 'category' ? 'show' : '' }}" id="services">
            <img src="{{ asset('category.png') }}" alt="">
            <div class="content-info">
                <h1 class="content-title">
                    All Student Categories
                </h1>
                @include('panel.settings.category')
            </div>
        </div>
        {{-- <div class="content {{ last(request()->segments()) === 'rejected' ? 'show' : '' }}" id="contact">
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
        </div> --}}
    </div>
    </di>
</div>
