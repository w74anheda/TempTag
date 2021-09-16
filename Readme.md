# Laravel TempTag

Auto-expiring tags with additional payload data on any eloquent model.
## Installation


first you need to install and configure mongodb in your laravel project with [jenssegers/laravel-mongodb](https://github.com/jenssegers/laravel-mongodb), then install package [m74asoud/temptag](https://github.com/masoudnazarpoor/TempTag) with below command
```bash
composer require m74asoud/temptag
```
## migrate table
```python
php artisan migrate
```

## Configure Model
```python
use M74asoud\TempTag\Traits\TempTagAble;

class User extend Model {
  use TempTagAble;
  protected $connection = 'mysql';
  protected $table = 'users';
}
```

## Usage
```python
$user->tempTagService()
->tagIt(
  string $title,
  $payload = null,
  Carbon $expire_at = null
): TempTag


$user->tempTagService()->unTag(string $title)
$user->tempTagService()->unTagID($ID)
$user->tempTagService()->get(string  $title): EloquentCollection
$user->tempTagService()->getOne(string  $title): ?TempTag
$user->tempTagService()->getOneID($ID): ?TempTag
$user->tempTagService()->all(): EloquentCollection
... and another method,complete readme file comming soon
```


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.


## License
[MIT](https://choosealicense.com/licenses/mit/)
