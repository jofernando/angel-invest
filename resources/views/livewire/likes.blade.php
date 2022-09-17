<div class="d-inline">
    @if ($curtiu)
        <img wire:click="descurtir" class="icon-like" src="{{asset('/img/heart-full.png')}}" alt="icone de curtiu">
    @else
        <img wire:click="curtir" class="icon-like" src="{{asset('/img/heart.png')}}" alt="icone de curtir">
    @endif
    {{$likes}}
</div>
