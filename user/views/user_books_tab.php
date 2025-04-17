<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="search-tab" data-bs-toggle="tab" data-bs-target="#search" type="button"
            role="tab" aria-controls="search" aria-selected="true">Filter & Borrow</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="loans-tab" data-bs-toggle="tab" data-bs-target="#loans" type="button" role="tab"
            aria-controls="loans" aria-selected="false">My Loans</button>
    </li>
</ul>

<div class="tab-content" id="userTabsContent">
    <div class="tab-pane fade show active" id="search" role="tabpanel" aria-labelledby="search-tab">
        <?php include 'search_section.php'; ?>
    </div>

    <div class="tab-pane fade" id="loans" role="tabpanel" aria-labelledby="loans-tab">
        <?php include 'loans_section.php'; ?>
    </div>
</div>