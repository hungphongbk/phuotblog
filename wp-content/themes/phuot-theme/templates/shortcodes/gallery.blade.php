<div class="gallery-carousel-wrapper">
    <div class="gallery galleryid-{{ $id }} gallery-carousel">
        <div class="ratio-16-9">
            <div class="content">
                <div class="slides">
                    @foreach($attachments as $id => $attachment)
                        <div class="slide">
                            {{ wp_get_attachment_image($id, 'gallery-carousel-slide', false) }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <ul class="navigations">
            @foreach($attachments as $id => $attachment)
                <li>
                {{ wp_get_attachment_image($id, 'gallery-carousel-thumbnail', false) }}
            @endforeach
        </ul>
    </div>
</div>