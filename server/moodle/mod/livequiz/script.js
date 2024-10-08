const fs = require('fs');
const path = require('path');
const uglifyJS = require('uglify-js');

/*
* THIS IS A TEMPORARY SCRIPT. A PROPER SOLUTION SHOULD BE IMPLEMENTED WITH GRUNT
* Dette script skal køres når du ønsker at se ændringer fra dit js.
*
* */




// Mapper
const srcDir = path.join(__dirname, 'amd', 'src');
const buildDir = path.join(__dirname, 'amd', 'build');

// Opret build-mappen, hvis den ikke findes
if (!fs.existsSync(buildDir)) {
  fs.mkdirSync(buildDir);
}

// Læs alle .js-filer fra src-mappen
fs.readdir(srcDir, (err, files) => {
  if (err) {
    console.error("Error reading the src directory:", err);
    return;
  }

  // Filtrer kun .js-filer
  files.filter(file => file.endsWith('.js')).forEach(file => {
    const srcFilePath = path.join(srcDir, file);
    const buildFilePath = path.join(buildDir, file.replace('.js', '.min.js'));

    // Læs indholdet af filen
    const code = fs.readFileSync(srcFilePath, 'utf8');

    // Uglify filen
    const result = uglifyJS.minify(code);

    if (result.error) {
      console.error(`Error minifying ${file}:`, result.error);
      return;
    }

    // Skriv den uglified version til build-mappen
    fs.writeFileSync(buildFilePath, result.code, 'utf8');
    console.log(`Successfully uglified: ${file} -> ${buildFilePath}`);
  });
});
