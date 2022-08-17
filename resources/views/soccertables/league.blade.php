@include('soccertables.includes.leaguehead', 
    ['columns' => ['Pos', 'Team', 'Pl', 'W', 'D', 'L', 'F', 'A', 'GD', 'Pts']])
@foreach($leaguetable as $pos => $row)
    <tr 
        @if(($row['border'] & 1) ==1) class="td-border-top" @endif
        @if($row['colour']) style="background-color:{{$row['colour']}}" @endif>
        <td class="td-border-left td-border-right">{{ $pos + 1 }} </td>
        <td class="td-border-right" style="text-align:left">{{ $row['teamname'] }} </td>
        <td>{{ $row['played'] }} </td>
        <td>{{ $row['won'] }} </td>
        <td>{{ $row['drawn'] }} </td>
        <td>{{ $row['lost'] }} </td>
        <td>{{ $row['for'] }} </td>
        <td>{{ $row['against'] }} </td>
        <td>{{ $row['diff'] }} </td>
        <td class="td-border-right">@if($row['pts_deducted']<0)*@endif {{ $row['points'] }} </td>
    </tr>
    @if(($row['border'] & 2) == 2)
        </tbody>
        @include('soccertables.includes.leaguehead',
            ['columns' => ['', '', '', '', '', '', '', '', '', '']])
    @endif
@endforeach
    </tbody>
</table>
<table style="width:560px;text-align:left;font-size:10px;">
        @foreach($leaguetable as $pos => $row)
            @if($row['pts_deducted'] < 0)
                <tr>
                    <td>{{ $row['teamname'] }} deducted {{ $row['pts_deducted'] }} points</td> 
                </tr> 
            @endif
        @endforeach
</table>
