# Tongue

"Tongue" is CakePHP controller action **dirty** "TypeHinting" plugin.

## Usage

```php
    public $components = array(
        'Tongue.Tongue'
    );
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
