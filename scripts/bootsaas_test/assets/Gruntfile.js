//Gruntfile.js

//our wrapper function (required by grunt and its plugins)
//all configuration goes inside this function
module.exports = function(grunt) {

	// ===========================================================================
	// CONFIGURE GRUNT ===========================================================
	// ===========================================================================
	grunt.initConfig({

		// get the configuration info from package.json ----------------------------
		// this way we can use things like name and version (pkg.name)
		pkg: grunt.file.readJSON('package.json'),

		// Config autoprefixer
		autoprefixer: {
			options: {
				browsers: ['last 2 versions', 'ie 8', 'ie 9'] 
			},
			your_target: {
				// Target-specific file lists and/or options go here.
			},
		},

		// Config sass
		sass: {                              // Task
			dist: {
				files: [{
					expand: true,
					cwd: 'stylesheets',
					src: ['*.scss'],
					dest: 'css',
					ext: '.css'
				}]
			}
		},

		jshint: {
			options: {
				reporter: require('jshint-stylish') // use jshint-stylish to make our errors look and read good
			},

			// when this task is run, lint the Gruntfile and all js files in src
			build: ['Gruntfile.js', 'javascripts/*.js']
		},

		// Config watch
		// Keep on
		watch: {
			scripts: {
				files: ['**/*.js'],
				tasks: ['jshint'],
				options: {
					spawn: false,
				},
			},
			css: {
		    files: '**/*.sass',
		    tasks: ['sass'],
		    options: {
		      livereload: true,
		    },
		  },
		}

	});

	// ===========================================================================
	// LOAD GRUNT PLUGINS ========================================================
	// ===========================================================================
	// we can only load these if they are in our package.json
	// make sure you have run npm install so our app can find these
	grunt.loadNpmTasks('grunt-autoprefixer');
//	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-sass');
	//grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-html');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Default task(s).
	grunt.registerTask('default', ['sass']);

};