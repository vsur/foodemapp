# Deploy Script
# Copies Files one in deploy Folder 
rsync -r cake/.htaccess deploy/
rsync -r cake/index.php deploy/

rsync -r cake/bin deploy/
rsync -r cake/config deploy/
rsync -r cake/logs deploy/
rsync -r cake/plugins deploy/

if [ ! -d "deploy/src" ]; then
  mkdir deploy/src
fi

rsync -r cake/src/Controller/Component deploy/src/Controller/
rsync -r cake/src/Controller/AppController.php deploy/src/Controller/
rsync -r cake/src/Controller/BinaryComponentsController.php deploy/src/Controller/
rsync -r cake/src/Controller/BinaryComponentsYpoisController.php deploy/src/Controller/
rsync -r cake/src/Controller/NominalAttributesController.php deploy/src/Controller/
rsync -r cake/src/Controller/NominalAttributesYpoisController.php deploy/src/Controller/
rsync -r cake/src/Controller/NominalComponentsController.php deploy/src/Controller/
rsync -r cake/src/Controller/OrdinalAttributesController.php deploy/src/Controller/
rsync -r cake/src/Controller/OrdinalAttributesYpoisController.php deploy/src/Controller/
rsync -r cake/src/Controller/OrdinalComponentsController.php deploy/src/Controller/
rsync -r cake/src/Controller/RequestEvaluationsController.php deploy/src/Controller/
rsync -r cake/src/Controller/PagesController.php deploy/src/Controller/
rsync -r cake/src/Controller/YpoisController.php deploy/src/Controller/

rsync -r cake/src/Model/Behavior deploy/src/Model/
rsync -r cake/src/Model/Entity/BinaryComponent.php deploy/src/Model/Entity/
rsync -r cake/src/Model/Entity/BinaryComponentsYpois.php deploy/src/Model/Entity/
rsync -r cake/src/Model/Entity/NominalAttribute.php deploy/src/Model/Entity/
rsync -r cake/src/Model/Entity/NominalAttributesYpois.php deploy/src/Model/Entity/
rsync -r cake/src/Model/Entity/NominalComponent.php deploy/src/Model/Entity/
rsync -r cake/src/Model/Entity/OrdinalAttribute.php deploy/src/Model/Entity/
rsync -r cake/src/Model/Entity/OrdinalAttributesYpois.php deploy/src/Model/Entity/
rsync -r cake/src/Model/Entity/OrdinalComponent.php deploy/src/Model/Entity/
rsync -r cake/src/Model/Entity/RequestEvaluation.php deploy/src/Model/Entity/
rsync -r cake/src/Model/Entity/Ypois.php deploy/src/Model/Entity/
rsync -r cake/src/Model/Table/BinaryComponentsTable.php deploy/src/Model/Table/
rsync -r cake/src/Model/Table/BinaryComponentsYpoisTable.php deploy/src/Model/Table/
rsync -r cake/src/Model/Table/NominalAttributesTable.php deploy/src/Model/Table/
rsync -r cake/src/Model/Table/NominalAttributesYpoisTable.php deploy/src/Model/Table/
rsync -r cake/src/Model/Table/NominalComponentsTable.php deploy/src/Model/Table/
rsync -r cake/src/Model/Table/OrdinalAttributesTable.php deploy/src/Model/Table/
rsync -r cake/src/Model/Table/OrdinalAttributesYpoisTable.php deploy/src/Model/Table/
rsync -r cake/src/Model/Table/OrdinalComponentsTable.php deploy/src/Model/Table/
rsync -r cake/src/Model/Table/RequestEvaluationTable.php deploy/src/Model/Table/
rsync -r cake/src/Model/Table/YpoisTable.php deploy/src/Model/Table/

rsync -r cake/src/Shell deploy/src

rsync -r cake/src/Template/BinaryComponents deploy/src/Template/
rsync -r cake/src/Template/BinaryComponentsYpois deploy/src/Template/
rsync -r cake/src/Template/Element deploy/src/Template/
rsync -r cake/src/Template/Email deploy/src/Template/
rsync -r cake/src/Template/Error deploy/src/Template/
rsync -r cake/src/Template/Layout deploy/src/Template/
rsync -r cake/src/Template/NominalAttributes deploy/src/Template/
rsync -r cake/src/Template/NominalAttributesYpois deploy/src/Template/
rsync -r cake/src/Template/NominalComponents deploy/src/Template/
rsync -r cake/src/Template/OrdinalAttributes deploy/src/Template/
rsync -r cake/src/Template/OrdinalAttributesYpois deploy/src/Template/
rsync -r cake/src/Template/OrdinalComponents deploy/src/Template/
if [ ! -d "deploy/src/Template/Pages" ]; then
  mkdir deploy/src/Template/Pages
fi
# Aktuell keine Pages aktiv
# rsync -r cake/src/Template/Pages deploy/src/Template/
rsync -r cake/src/Template/RequestEvaluations deploy/src/Template/
rsync -r cake/src/Template/Ypois deploy/src/Template/

rsync -r cake/src/View deploy/src/
#rsync -r cake/src deploy/

rsync -r cake/tests deploy/

if [ -d "deploy/tmp" ]; then
  rm -R deploy/tmp/*
fi
if [ ! -d "deploy/tmp" ]; then
  mkdir deploy/tmp
fi

rsync -r cake/vendor deploy/

if [ ! -d "deploy/webroot" ]; then
  mkdir deploy/webroot
fi
rsync -r cake/webroot/.htaccess deploy/webroot/
rsync -r cake/webroot/css deploy/webroot/
rsync -r cake/webroot/favicon.ico deploy/webroot/
rsync -r cake/webroot/fonts deploy/webroot/
rsync -r cake/webroot/img deploy/webroot/
rsync -r cake/webroot/index.php deploy/webroot/
rsync -r cake/webroot/js deploy/webroot/