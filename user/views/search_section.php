<div class="card">
    <div class="card-header">
        <h4>Filter & Borrow Books</h4>
    </div>
    <div class="card-body">
        <div class="row g-2 mb-3 align-items-center flex-nowrap overflow-auto">
            <div class="col-auto flex-shrink-0">
                <select class="form-select form-select-sm" id="genreFilter">
                    <option value="">All Genres</option>
                </select>
            </div>

            <div class="col-auto flex-shrink-0">
                <select class="form-select form-select-sm" id="availabilityFilter">
                    <option value="all">All Books</option>
                    <option value="available">Available Only</option>
                    <option value="unavailable">Unavailable</option>
                </select>
            </div>

            <div class="col-auto flex-shrink-0">
                <select class="form-select form-select-sm" id="sortFilter">
                    <option value="title_asc">Title (A-Z)</option>
                    <option value="title_desc">Title (Z-A)</option>
                    <option value="author_asc">Author (A-Z)</option>
                    <option value="author_desc">Author (Z-A)</option>
                    <option value="popular">Most Popular</option>
                </select>
            </div>

            <div class="col-auto flex-shrink-0">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" id="userPageSearch"
                        placeholder="Search books, author or ISBN"
                        onkeyup="if(event.keyCode === 13) $('#userPageSearchBtn').click()">
                    <button class="btn btn-sm btn-info" id="userPageSearchBtn">Search</button>
                </div>
            </div>
        </div>
        <div id="filterResults" class="mt-3"></div>
    </div>
</div>