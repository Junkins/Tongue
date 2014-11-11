# Tongue

"Tongue" is CakePHP controller action **dirty** "TypeHinting" plugin.

## Usage

```php
// PostsController.php
    public $components = [
        'Tongue.Tongue'
    ];

    public function view(TNumeric $id) { // <= TypeHinting!!!
        $post = $this->Post->findById($id);
        $this->set(compact('post'));
    }
```

## License

The MIT License
