<div class="chat-list">
    <ul id="scrollDiv" class="single-chat-head">

        <ul class="chat-list">
            @foreach ($messages as $m)
            @if ($m->receiver_id == auth()->id())
            <li class="right">
                @if ($m->sender->avatar)
                <img class="profile" src="{{ asset('storage/users-avatar/' . $m->sender->avatar) }}" alt="#">
                @else
                <img class="profile" src="{{ asset('storage/images/default.jpg') }}" alt="#">
                @endif
                <div class="text">
                    <span class="float-end" style="font-size:0.7rem;margin-top:-15px;">
                        {{ date('d M, Y', strtotime($m->created_at)) }}
                    </span>
                    <b class="d-inline d-flex time">{{ $m->sender->name }}</b>
                    @if (!empty($m->image))
                    <div class="col-12 mt-2 mb-2">
                        <img class="img-thumbnail" src="{{ asset('storage/chat/'.$m->image) }}" alt="#"
                            data-bs-toggle="modal" data-bs-target="#imageModal"
                            data-image="{{ asset('storage/chat/'.$m->image) }}">
                    </div>
                    @endif
                    {!! $m->content !!}
                    <span class="time" style="font-size:0.7rem">{{ $m->created_at->format('h:i A') }}</span>
                </div>
            </li>
            @elseif ($m->receiver_id !== auth()->id())
            <li class="left">
                @if ($m->sender->avatar)
                <img class="profile" src="{{ asset('storage/users-avatar/' . $m->sender->avatar) }}" alt="#">
                @else
                <img class="profile" src="{{ asset('storage/images/default.jpg') }}" alt="#">
                @endif
                <div class="text">
                    <span class="float-end" style="font-size:0.7rem;margin-top:-15px;">
                        {{ date('d M, Y', strtotime($m->created_at)) }}
                    </span>
                    <b class="d-inline d-flex time">{{ $m->sender->name }}</b>
                    @if (!empty($m->image))
                    <div class="col-12 mt-2 mb-2">
                        <img class="img-thumbnail" src="{{ asset('storage/chat/'.$m->image) }}" alt="#"
                            data-bs-toggle="modal" data-bs-target="#imageModal"
                            data-image="{{ asset('storage/chat/'.$m->image) }}">
                    </div>
                    @endif
                    {!! $m->content !!}
                    <span class="time" style="font-size:0.7rem">{{ $m->created_at->format('h:i A') }}</span>
                </div>
            </li>
            @endif
            @endforeach
        </ul>


    </ul>

    <div class="reply-block">
        <ul class="add-media-list">
            <li>
                <label for="file-link" class="file-label">
                    <input id="file-link" type="file" name="images" style="display: none;">
                    <div id="image-icon">.
                        <i id="icon" class="lni lni-image"></i>
                    </div>
                </label>
            </li>
        </ul>
        <input id="send-id" name="sender" type="hidden" value="">
        <input id="input-chat" name="reply" type="text" placeholder="Ketik pesan...">
        <button class="reply-btn" id="send-btn">
            <img src="{{ asset('storage/images/items-grid/send.svg') }}" alt="#">
        </button>
    </div>


</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img id="modalImage" src="" alt="#" style="width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#file-link").change(function() {
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            $('#icon').hide();
            reader.onload = function(e) {
                $("#image-icon").html('<img id="uploaded-image" style="width:35px" src="' + e.target.result + '" alt="">');
            };
            reader.readAsDataURL(file);
        });

        $('#input-chat').focus();
        var scrollDiv = $("#scrollDiv");
        var scrollHeight = scrollDiv.prop("scrollHeight");
        scrollDiv.animate({ scrollTop: scrollHeight }, 1000);

        $('#send-btn').click(function() {
            sendMessage();
        });

        $('#input-chat').keypress(function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });


        function sendMessage() {
            // Mengambil nilai input
            var reply = $('#input-chat').val();
            var images = $('#file-link')[0].files[0];
            var sen_id = $('#send-id').val();
            var user_id = '{{ auth()->id() }}';
            
            // Membuat objek FormData untuk mengirim data
            var formData = new FormData();
            formData.append('reply', reply);
            formData.append('sender_id', sen_id);

            // Memeriksa apakah file telah dipilih sebelum menambahkannya ke formData
            if (images) {
                formData.append('images', images);
            }

            // Mendapatkan token CSRF
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
 
            // Mengirim data pesan menggunakan AJAX
            $.ajax({
                url: "{{ route('pesan.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {

                    openChat(sen_id, user_id);

                    Swal.fire({
                        icon: 'success',
                        toast: true,
                        title: 'Pesan Terkirim',
                        text: 'Pesan Anda telah berhasil terkirim.',
                        timer: 4000,
                        position: 'top-end',
                        showConfirmButton: false
                    });

                },
                error: function(xhr, status, error) {
                    var responseErrors = xhr.responseJSON.errors;
                    if (responseErrors) {
                        // Menampilkan pesan kesalahan validasi
                        $.each(responseErrors, function(field, errors) {
                            // Anda dapat menyesuaikan cara menampilkan pesan kesalahan sesuai dengan kebutuhan Anda
                            console.log('Validation Error in field: ' + field);
                            console.log('Error Messages: ' + errors.join(', '));
                        });
                    } else {
                        console.log('Error: ' + error);
                    }
                }
            });

        }

        $(".img-thumbnail").click(function() {
            var imageSrc = $(this).data("image");
            $("#modalImage").attr("src", imageSrc);
            $("#imageModal").modal("show");
        });
    });
</script>