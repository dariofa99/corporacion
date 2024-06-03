@forelse($user->getReferences('about_me', 'type_data_user') as $key => $reference)
    <strong><i class="fas fa-star mr-1"></i>{{ $reference->name }}</strong>
    <input {{ isset($disabled) ? $disabled : '' }} data-reference_id="{{ $reference->id }}"
        data-name="{{ $reference->name }}" data-option="{{ $reference->options[0]->id }}"
        data-type="{{ $reference->type_data_id }}" name="static_data[]" data-section="{{ $reference->section }}"
        type="hidden" id="input_about_me-{{ $reference->id }}"
        @if (isset($user) and $reference->options[0] and $user->getDataVal($reference->id, $reference->options[0]->id)) value="{{ $user->getDataVal($reference->id, $reference->options[0]->id)->value }}" @endif
        class="form-control form-control-sm input_user_data">

    <p class="text-muted" id="lbl_btn_dedit-{{$reference->id }}">
        @if ($canedit)
            <i style="font-size:12px" id="btn_dedit-{{ $reference->id }}" data-id="{{ $reference->id }}"
                class="fa fa-edit  btn_dedit">
            </i>
        @endif
        <span>
            @if (isset($user) and $reference->options[0] and $user->getDataVal($reference->id, $reference->options[0]->id))
               <span id="lblTextQu-{{ $reference->id }}">
                {{ $user->getDataVal($reference->id, $reference->options[0]->id)->value }}
                </span> 
            @else
                --
            @endif
        </span>
    </p>
    <hr>
@empty
@endforelse
{{-- @include('content.categories.partials.questions', [
    'col' => 12,
    'model' => $user,
    'data' => $user->getReferences('about_me', 'type_data_user'),
]) --}}
