# Models - Database Classes
The models are php files that extend the Model (database) class from Laravel. It is: Illuminate\Database\Eloquent\Model
### ACP Usage
Follows the standard Laravel conventions.
### ptclinic.biz usage
Uses Capsule to access the models. It uses the makeCapsule.php file to create the connection.

Example of using with a .biz php file
```
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\NAME;

$something   = NAME::find( $id );

$result = Capsule::table('tablename')->where("field", "value")->orderBy("field", "asc")->first();
```

## ddl Files (subdirectory)
**webreha_practice** is the database name. 

These .sql files are generated from PHPStorm using the **Database** window and then right clicking a table or the database, then choose **"Import/Export"**, then **"Dump to DDL Data Source"**, then use the data source you setup in PHPStorm for the ddl directory in the AppModels repo subdirectory.


