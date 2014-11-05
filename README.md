# Tongue

"Tongue" is CakePHP controller action **dirty** "TypeHinting" plugin.

## Usage

```php
// bootstrap.php
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher',
    'Tongue.TongueDispatcher', // Add
));
```

```php
// PostsController.php
    public function view(TNumeric $id) { // <= TypeHinting!!!
        $post = $this->Post->findById($id);
        $this->set(compact('post'));
    }
```

## License

The MIT License
