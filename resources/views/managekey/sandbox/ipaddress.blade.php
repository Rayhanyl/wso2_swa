<div class="pl-5">
    <div class="card rounded-3">
        <div class="row p-3">
            {{-- <div class="col-12">
                <h5>Key Restrictions</h5>
                <hr>
            </div> --}}
            <div class="col-6">
                <h4>Examples of IP Addresses allowed</h4>
                <p class="fw-light">Specify one IPv4 or IPv6 or a subnet using CIDR notation</p>
                <p class="fw-light">Examples: 192.168.1.2, 152.12.0.0/13, 2002:eb8::2 or 1001:ab8::/44</p>
            </div>
            <div class="col-6 mt-2">
                <form action="#">
                    <div class="row g-3"> 
                        <div class="col-10">
                        <input type="text" class="form-control textaddress" id="addip" placeholder="IP ADDRESS">
                        </div>
                        <div class="col-2">
                        <button class="btn btn-outline-warning mb-3 addip btn-icon-ip"><i class='bx bx-plus'></i></button>
                        </div>
                    </div>
                    <div class="col-10 d-grid gap-2 mb-3">
                        <button class="btn btn-primary generate" type="button"
                        data-bs-toggle="modal" data-bs-target="#generateapikey" form="generateapikey">
                        Generate Key
                        </button>
                    </div>
                    <div id="none" class="form-text">Use the Generate Key button to generate a self-contained JWT token.</div>
                </form>
            </div>
            <div class="col-12 mt-3">
                {{-- <hr> --}}
                <div class="row p-3 boxaddress">
                </div>
            </div>
        </div>
    </div>
</div>


