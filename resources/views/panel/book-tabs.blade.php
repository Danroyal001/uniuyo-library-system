<div class="container">
    <div class="tab-buttons">
        <button class="tab-btn active" content-id="home" onclick="loadResults('issued')">
            Issued Books
        </button>
        <button class="tab-btn" content-id="services" onclick="loadResults('returned', 'return-logs-table')">
            Returned Books
        </button>
        <button class="tab-btn" content-id="contact" onclick="loadResults('overdue', 'overdue-logs-table')">
            overdue Books
        </button>
        <button class="tab-btn" content-id="about" onclick="loadResults('lost', 'lost-logs-table')">
            Losted Books
        </button>
    </div>
    <div class="tab-contents">
        <div class="content show " id="home">
            <img src="{{ asset('new.png') }}" alt="">
            <div class="content-info">
                <h1 class="content-title">
                    All Issued Books
                </h1>
                @include('panel.books.all-issues')
            </div>
        </div>
        <div class="content" id="services">
            <img src="{{ asset('approval.png') }}" alt="">
            <div class="content-info">
                <h1 class="content-title">
                    All Returned Books
                </h1>
                @include('panel.books.all-returns')
            </div>
        </div>
        <div class="content" id="contact">
            <img src="{{ asset('rejected.png') }}" alt="">
            <div class="content-info">
                <h1 class="content-title">
                    All Overdue Books
                </h1>
                @include('panel.books.all-overdues')
            </div>
        </div>
        <div class="content" id="about">
            <img src="{{ asset('block.png') }}" alt="" width="220">
            <div class="content-info">
                <h1 class="content-title">
                    All Losts Books
                </h1>
                @include('panel.books.all-losts')
            </div>
        </div>
    </div>
    </di>
</div>
