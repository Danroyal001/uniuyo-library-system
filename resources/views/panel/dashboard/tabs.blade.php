<div class="container">
    <div class="tab-buttons">
        <button class="tab-btn {{ last(request()->segments()) === 'home1' ? 'active' : '' }}" content-id="home"
            onclick1="loadResults('branch')">
            Dashboard
        </button>
        <button class="tab-btn {{ last(request()->segments()) === 'home' ? 'active' : '' }}" content-id="services"
            onclick1="loadResults('category', 'category-table')">
            Student Category
        </button>
    </div>
    <div class="tab-contents">
        <div class="content {{ last(request()->segments()) === 'home1' ? 'show' : '' }} " id="home">
            <img src="{{ asset('branch.png') }}" alt="">
            <div class="content-info">
                <h1 class="content-title">
                    All School Branches
                </h1>
                @include('panel.dashboard.statistic')
            </div>
        </div>
        <div class="content {{ last(request()->segments()) === 'home' ? 'show' : '' }}" id="services">
            {{-- <img src="{{ asset('category.png') }}" alt=""> --}}
            {{-- <div class="content-info">
                <h1 class="content-title">
                    Filter
                </h1> --}}
            @include('panel.dashboard.filter')
            {{-- </div> --}}
        </div>
    </div>
    </di>
</div>


