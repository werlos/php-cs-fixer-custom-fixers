# PHP CS Fixer: custom fixers

[![Latest stable version](https://img.shields.io/packagist/v/kubawerlos/php-cs-fixer-custom-fixers.svg?label=current%20version)](https://packagist.org/packages/kubawerlos/php-cs-fixer-custom-fixers)
[![PHP version](https://img.shields.io/packagist/php-v/kubawerlos/php-cs-fixer-custom-fixers.svg)](https://php.net)
[![License](https://img.shields.io/github/license/kubawerlos/php-cs-fixer-custom-fixers.svg)](LICENSE)
![Repository size](https://github-size-badge.herokuapp.com/kubawerlos/php-cs-fixer-custom-fixers.svg)
[![Last commit](https://img.shields.io/github/last-commit/kubawerlos/php-cs-fixer-custom-fixers.svg)](https://github.com/kubawerlos/php-cs-fixer-custom-fixers/commits)

[![Build status](https://img.shields.io/travis/kubawerlos/php-cs-fixer-custom-fixers/master.svg)](https://travis-ci.org/kubawerlos/php-cs-fixer-custom-fixers)
[![Code coverage](https://img.shields.io/coveralls/github/kubawerlos/php-cs-fixer-custom-fixers/master.svg)](https://coveralls.io/github/kubawerlos/php-cs-fixer-custom-fixers?branch=master)
![Tests](https://img.shields.io/badge/tests-1076-brightgreen.svg)
[![Mutation testing badge](https://badge.stryker-mutator.io/github.com/kubawerlos/php-cs-fixer-custom-fixers/master)](https://stryker-mutator.github.io)

A set of custom fixers for [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer).

## Installation
PHP CS Fixer: custom fixers can be installed by running:
```bash
composer require --dev kubawerlos/php-cs-fixer-custom-fixers
```


## Usage
In your PHP CS Fixer configuration register fixers and use them:
```diff
 <?php
 return PhpCsFixer\Config::create()
+    ->registerCustomFixers(new PhpCsFixerCustomFixers\Fixers())
     ->setRules([
         '@PSR2' => true,
         'array_syntax' => ['syntax' => 'short'],
+        PhpCsFixerCustomFixers\Fixer\NoLeadingSlashInGlobalNamespaceFixer::name() => true,
+        PhpCsFixerCustomFixers\Fixer\PhpdocNoSuperfluousParamFixer::name() => true,
     ]);
```


## Fixers
#### CommentSurroundedBySpacesFixer
Comment must be surrounded by spaces.
```diff
 <?php
-/*foo*/
+/* foo */
```

#### DataProviderNameFixer
Name of data provider that is used only once must match name of test.  
*Risky: when relying on name of data provider function.*
```diff
 <?php
 class FooTest extends TestCase {
     /**
-     * @dataProvider dataProvider
+     * @dataProvider provideHappyPathCases
      */
     function testHappyPath() {}
-    function dataProvider() {}
+    function provideHappyPathCases() {}
 }
```

#### DataProviderReturnTypeFixer
Return type of data provider must be `iterable`.  
*Risky: when relying on signature of data provider.*
```diff
      * @dataProvider provideHappyPathCases
      */
     function testHappyPath() {}
-    function provideHappyPathCases(): array {}
+    function provideHappyPathCases(): iterable {}
 }
```

#### ImplodeCallFixer
Function `implode` must be called with 2 arguments in the documented order.  
DEPRECATED: use `implode_call` instead.  
*Risky: when the function `implode` is overridden.*
```diff
 <?php
-implode($foo, "") . implode($bar);
+implode("", $foo) . implode('', $bar);
```

#### InternalClassCasingFixer
Class defined internally by an extension, or the core should be called using the correct casing.
```diff
 <?php
-$foo = new STDClass();
+$foo = new stdClass();
```

#### MultilineCommentOpeningClosingAloneFixer
Multiline comment/PHPDoc must have opening and closing line without any extra content.
```diff
 <?php
-/** Hello
+/**
+ * Hello
  * World!
  */;
```

#### NoCommentedOutCodeFixer
There should be no commented out code.
```diff
 <?php
-//var_dump($_POST);
 print_r($_POST);
```

#### NoDoctrineMigrationsGeneratedCommentFixer
There must be no comment generated by Doctrine Migrations.
```diff
 <?php
 namespace Migrations;
 use Doctrine\DBAL\Schema\Schema;
-/**
- * Auto-generated Migration: Please modify to your needs!
- */
 final class Version20180609123456 extends AbstractMigration
 {
     public function up(Schema $schema)
     {
-        // this up() migration is auto-generated, please modify it to your needs
         $this->addSql("UPDATE t1 SET col1 = col1 + 1");
     }
     public function down(Schema $schema)
     {
-        // this down() migration is auto-generated, please modify it to your needs
         $this->addSql("UPDATE t1 SET col1 = col1 - 1");
     }
 }
```

#### NoDuplicatedImportsFixer
Duplicated `use` statements must be removed.
```diff
 <?php
 namespace FooBar;
 use Foo;
-use Foo;
 use Bar;
```

#### NoImportFromGlobalNamespaceFixer
There must be no import from global namespace.
```diff
 <?php
 namespace Foo;
-use DateTime;
 class Bar {
-    public function __construct(DateTime $dateTime) {}
+    public function __construct(\DateTime $dateTime) {}
 }
```

#### NoLeadingSlashInGlobalNamespaceFixer
When in global namespace there must be no leading slash for class.
```diff
 <?php
-$x = new \Foo();
+$x = new Foo();
 namespace Bar;
 $y = new \Baz();
```

#### NoNullableBooleanTypeFixer
There must be no nullable boolean type.  
*Risky: when the null is used.*
```diff
 <?php
-function foo(?bool $bar) : ?bool
+function foo(bool $bar) : bool
 {
      return $bar;
  }
```

#### NoPhpStormGeneratedCommentFixer
There must be no comment generated by PhpStorm.
```diff
 <?php
-/**
- * Created by PhpStorm.
- * User: root
- * Date: 01.01.70
- * Time: 12:00
- */
 namespace Foo;
```

#### NoReferenceInFunctionDefinitionFixer
There must be no reference in function definition.  
*Risky: when rely on reference.*
```diff
 <?php
-function foo(&$x) {}
+function foo($x) {}
```

#### NoTwoConsecutiveEmptyLinesFixer
There must be no two consecutive empty lines in code.  
DEPRECATED: use `no_extra_blank_lines` instead.
```diff
 <?php
 namespace Foo;
 
-
 class Bar {};
```

#### NoUnneededConcatenationFixer
There should not be inline concatenation of strings.
```diff
 <?php
-echo 'foo' . 'bar';
+echo 'foobar';
```

#### NoUselessClassCommentFixer
There must be no comment like: "Class FooBar".  
DEPRECATED: use `NoUselessCommentFixer` instead.
```diff
 <?php
 /**
- * Class FooBar
  * Class to do something
  */
 class FooBar {}
```

#### NoUselessCommentFixer
There must be no comment like "Class Foo".
```diff
 <?php
 /**
- * Class Foo
  * Class to do something
  */
 class Foo {
     /**
-     * Get bar
      */
     function getBar() {}
 }
```

#### NoUselessConstructorCommentFixer
There must be no comment like: "Foo constructor".  
DEPRECATED: use `NoUselessCommentFixer` instead.
```diff
 <?php
 class Foo {
     /**
-     * Foo constructor
      */
     public function __construct() {}
 }
```

#### NoUselessDoctrineRepositoryCommentFixer
There must be no comment generated by the Doctrine ORM.
```diff
 <?php
-/**
- * FooRepository
- *
- * This class was generated by the Doctrine ORM. Add your own custom
- * repository methods below.
- */
 class FooRepository extends EntityRepository {}
```

#### NoUselessSprintfFixer
Function `sprintf` without parameters should not be used.  
*Risky: when the function `sprintf` is overridden.*
```diff
 <?php
-$foo = sprintf('Foo');
+$foo = 'Foo';
```

#### NullableParamStyleFixer
Nullable parameters must be written in the consistent style.
Configuration options:
- `style` (`'with_question_mark'`, `'without_question_mark'`): whether nullable parameter type should be prefixed or not with question mark; defaults to `with_question_mark`
```diff
 <?php
-function foo(int $x = null) {
+function foo(?int $x = null) {
 }
```

#### OperatorLinebreakFixer
Operators must always be at the beginning or at the end of the line.  
*To be deprecated after [this](https://github.com/FriendsOfPHP/PHP-CS-Fixer/pull/4021) is merged and released.*
Configuration options:
- `only_booleans` (`bool`): whether to limit operators to only boolean ones; defaults to `false`
- `position` (`'beginning'`, `'end'`): whether to place operators at the beginning or at the end of the line; defaults to `beginning`
```diff
 <?php
 function foo() {
-    return $bar ||
-        $baz;
+    return $bar
+        || $baz;
 }
```

#### PhpUnitNoUselessReturnFixer
PHPUnit's functions `fail`, `markTestIncomplete` and `markTestSkipped` should not be followed directly by return.  
*Risky: when PHPUnit's native methods are overridden.*
```diff
 class FooTest extends TestCase {
     public function testFoo() {
         $this->markTestSkipped();
-        return;
     }
 }
```

#### PhpdocNoIncorrectVarAnnotationFixer
`@var` must be correct in the code.
```diff
 <?php
-/** @var Foo $foo */
 $bar = new Foo();
```

#### PhpdocNoSuperfluousParamFixer
There must be no superfluous parameters in PHPDoc.
```diff
 <?php
 /**
  * @param bool $b
- * @param int $i
  * @param string $s this is string
- * @param string $s duplicated
  */
 function foo($b, $s) {}
```

#### PhpdocParamOrderFixer
`@param` annotations must be in the same order as function's parameters.
```diff
 <?php
 /**
+ * @param int $a
  * @param int $b
- * @param int $a
  * @param int $c
  */
 function foo($a, $b, $c) {}
```

#### PhpdocParamTypeFixer
`@param` must have type.
```diff
 <?php
 /**
  * @param string $foo
- * @param        $bar
+ * @param mixed  $bar
  */
 function a($foo, $bar) {}
```

#### PhpdocSelfAccessorFixer
In PHPDoc inside class or interface element `self` should be preferred over the class name itself.
```diff
 <?php
 class Foo {
     /**
-     * @var Foo
+     * @var self
      */
      private $instance;
 }
```

#### PhpdocSingleLineVarFixer
`@var` annotation must be in single line when is the only content.
```diff
 <?php
 class Foo {
-    /**
-     * @var string
-     */
+    /** @var string */
     private $name;
 }
```

#### PhpdocVarAnnotationCorrectOrderFixer
`@var` and `@type` annotations must have type and name in the correct order.  
DEPRECATED: use `phpdoc_var_annotation_correct_order` instead.
```diff
 <?php
-/** @var $foo int */
+/** @var int $foo */
 $foo = 2 + 2;
```

#### SingleLineThrowFixer
`throw` must be single line.  
*To be deprecated after [this](https://github.com/FriendsOfPHP/PHP-CS-Fixer/pull/4452) is merged and released.*
```diff
 <?php
-throw new Exception(
-    'Error',
-    500
-);
+throw new Exception('Error', 500);
```

#### SingleSpaceAfterStatementFixer
Single space must follow - not followed by semicolon - statement.
Configuration options:
- `allow_linebreak` (`bool`): whether to allow statement followed by linebreak; defaults to `false`
```diff
 <?php
-$foo = new    Foo();
-echo$foo->__toString();
+$foo = new Foo();
+echo $foo->__toString();
```

#### SingleSpaceBeforeStatementFixer
Single space must precede - not preceded by linebreak - statement.
```diff
 <?php
-$foo =new Foo();
+$foo = new Foo();
```


## Contributing
Request feature or report bug by creating [issue](https://github.com/kubawerlos/php-cs-fixer-custom-fixers/issues).

Alternatively, fork the repo, develop your changes, regenerate `README.md`:
```bash
./src-dev/Readme/run > README.md
```
make sure all checks pass:
```bash
composer verify
```
and submit pull request.
