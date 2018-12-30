@php
    $state = \App\Utils\Solution::getStateH( $exam_user_id );
    [$r,$w] = \App\Utils\Solution::getScore($exam_user_id);
@endphp

<span class="state-badge">
    {{ $state  }}
    @if( $state == 'Completo' && $r+$w != 0 )
        <span class="sub-state-badge">Nota: {{ intval(100*($r/($r+$w))) }}%</span>
    @endif
</span>