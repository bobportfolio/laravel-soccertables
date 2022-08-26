<hr style="border-color:darkgrey">
<div>
    Copyright &copy; {{ now()->year }} Robert Smith
</div>
<div>
    laravel: {{ app()->version() }} &bull;
    php: {{ phpversion() }} &bull;
    mysql: {{ $mysql_version }} &bull;
    apache: {{ $apache_version }}
</div>
<div><br></div>
