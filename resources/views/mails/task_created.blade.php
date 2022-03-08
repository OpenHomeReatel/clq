@extends('layouts.mail')

@section('content')
<table role="presentation" class="main">
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <p>Hi {{ $task->user->full_name }},</p>
                        <p>{{$message->subject()}}</p>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                            <tbody>
                                <tr>
                                    <td align="left">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <th>Type </th>
                                                    <th> {{ $task->type }} </th> 
                                                </tr>
                                                <tr>
                                                    <th> Status </th>
                                                    <th> {{ $task->status }} </th> 
                                                </tr>
                                                <tr>
                                                    <th> Note </th>
                                                    <th> {{ $task->note }} </th> 
                                                </tr>
                                                <tr>
                                                    <th> Due Date</th>
                                                    <th> {{ $task->date }} </th> 
                                                </tr>
                                                <tr>
                                                    <th> Time</th>
                                                    <th> {{ $task->time }} </th> 
                                                </tr>
                                                   
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p>This is a really simple email template. Its sole purpose is to get the recipient to click the button with no distractions.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection()

