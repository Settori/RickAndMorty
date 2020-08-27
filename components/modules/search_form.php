<form id="search-form" class="mb-5 custom-form">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="searchInput" class="mt-2 mb-0">Character name</label>
                <input type="text" class="form-control osr text-center" id="searchInput" autofocus>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="searchSelectStatus" class="mt-2 mb-0">Status</label>
                <select class="form-control" id="searchSelectStatus">
                    <option value='all'>All</option>
                    <option value='alive'>Alive</option>
                    <option value='dead'>Dead</option>
                    <option value='unknown'>Unknown</option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="searchSelectGender" class="mt-2 my-0">Gender</label>
                <select class="form-control" id="searchSelectGender">
                    <option value='all'>All</option>
                    <option value='male'>Male</option>
                    <option value='female'>Female</option>
                    <option value='genderless'>Genderless</option>
                    <option value='unknown'>Unknown</option>
                </select>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col text-center mt-3">
            <button type="button" class="btn btn-outline-primary px-4 text-uppercase " id="searchLucky">Lucky portal</button>
            <button type="submit" class="btn btn-outline-primary px-4 text-uppercase ml-3">Search</button>
        </div>
    </div>
</form>