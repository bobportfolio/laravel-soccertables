<div>© Copyright {{ now()->year }} Robert Smith, ebob.uk</div>
<div>
    laravel: {{ app()->version() }} &bull;
    php: {{ phpversion() }} &bull;
    mysql: {{ $mysql_version }} &bull;
    apache: {{ $apache_version }}
</div>
