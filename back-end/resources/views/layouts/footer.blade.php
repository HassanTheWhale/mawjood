<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 span" id="profileModalLabel">Profile Setting</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-black">
                {{-- <div class="card rounded overflow-hidden p-2 mb-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ $user->picture }}" alt="event" width="64px" class="rounded-circle" />
                        <span class="text-muted ms-3">{{ $user->username }}</span>
                    </div>
                </div> --}}
                <a href="#" onclick="privateEvent()" class="mb-2 d-block"><button
                        class="btn btn-outline-primary w-100 px-4">Join
                        Private Event</button></a>
                <a href="./create" class="mb-2 d-block"><button class="btn btn-primary text-white w-100 px-4">Create an
                        Event</button></a>
                <a href="./edit" class="mb-2 d-block"><button class="btn btn-secondary w-100 px-4">Edit
                        Profile</button></a>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="d-block" />
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <button class="btn btn-outline-secondary w-100">
                    Logout
                </button>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    const button = document.querySelector("#profileButton");
    let isButtonHeld = false;
    let timeoutId;
    let profileModal = new bootstrap.Modal(document.getElementById("profileModal"), {
        keyboard: true,
    });

    async function privateEvent() {
        profileModal.hide();

        const {
            value: ipAddress
        } = await Swal.fire({
            title: 'Enter the private key',
            input: 'text',
            confirmButtonText: 'Sign Up!',
            confirmButtonColor: '#56c4cf',
            cancelButtonColor: '#d33',
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to write something!';
                } else {
                    window.location.href = `./event/${value}/privatesignup`
                }
            }
        })
    }

    button.addEventListener("mousedown", function() {
        timeoutId = setTimeout(function() {
            isButtonHeld = true;
            console.log("Button held for 3 seconds");
            profileModal.toggle();
        }, 1000);
    });

    button.addEventListener("mouseup", function() {
        clearTimeout(timeoutId);
        if (isButtonHeld) return;
        console.log("Button held bfore 3 seconds");
        window.location.assign("./profile");
    });
</script>
@yield('scripts')
</body>

</html>
