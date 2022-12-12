<?php

# Download updates
exec('npm i');

# Copy files
copy('node_modules/bootstrap-icons/font/bootstrap-icons.json', 'Tools/bootstrap/bootstrap-icons.json');

copy('node_modules/font-awesome/less/variables.less', 'Tools/fa4/variables.less');
copy('node_modules/font-awesome/scss/_variables.scss', 'Tools/fa4/variables.scss');

copy('node_modules/font-awesome-v5-icons/data/icons.json', 'Tools/fa5/icons.json');

copy('node_modules/fontawesome-free/metadata/icons.json', 'Tools/fa6/icons.json');

copy('node_modules/feather-icons/dist/icons.json', 'Tools/feather/icons.json');

copy('node_modules/material-symbols/index.d.ts', 'Tools/material/index.d.ts');
