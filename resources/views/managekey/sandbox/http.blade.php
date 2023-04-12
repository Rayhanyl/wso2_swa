<div class="pl-5">
    <div class="card rounded-3">
        <div class="row p-3">
            <div class="col-6">
                <h4>Examples of URLs allowed to restrict websites</h4>
                <p class="fw-light">A specific URL with an exact path: <b> www.example.com/path</b></p>
                <p class="fw-light">Any URL in a single subdomain, using a wildcard asterisk (*):</p>
                <p class="fw-bold">sub.example.com/*</p>
                <p class="fw-light">Any subdomain or path URLs in a single domain, using wildcard asterisks (*):</p>
                <p class="fw-bold">*.example.com/*</p>
            </div>
            <div class="col-6 mt-2 text-center">
                <form class="row g-3" action="#">
                    <div class="col-12">
                        <div class="row g-3 d-flex justify-content-center">
                            <div class="col-10">
                                <input type="text" class="form-control texthttp" id="addhttp" placeholder="Enter Http Referer">
                            </div>
                            <div class="col-2 text-start">
                                <button type="button" class="btn btn-outline-warning mb-3 addhttp btn-icon-ip"><i class='bx bx-plus'></i></button>
                            </div>
                        </div>
                    </div> 
                    <div class="col-10 d-grid gap-2 mb-3">
                        <button class="btn btn-primary generate" type="button"
                        data-bs-toggle="modal" data-bs-target="#generateapikey" form="generateapikey">
                        GENERATE KEY
                        </button>
                    </div>
                    <div id="none" class="form-text">Use the Generate Key button to generate a self-contained JWT token.</div>
                </form>
            </div>
            <div class="col-12 mt-3">
                <div class="row p-3 boxhttp">
                </div>
            </div>
        </div>
    </div>
</div>
