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
				browsers: ['last 2 version', 'ie 8', 'ie 9', 'Opera 12.1']
			},
			main: {
				src: 'css/*.css',
				dest: 'prefixed/prefd.css'
			}
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
			build: {
				src: ['Gruntfile.js', '!javascripts/bootstrap*.js', 'javascripts/fmapp_data.js'],
				dest: 'js/'
			}
		},

		concat: {
			basic: {
				src: ['javascripts/bootstrap.js', 'javascripts/fmapp_app.js'],
				dest: 'js/boot_fmapp_app.js',
			},
			noBoot: {
				src: ['javascripts/fmapp_data.js'],
				dest: 'js/fmapp_data.js',
			}
		},

		// Config watch
		// Keep on
		watch: {
			scripts: {
				files: ['**/*.js'],
				tasks: ['jshint', 'concat:noBoot'],
				options: {
					spawn: false,
				},
			},
			css: {
				files: '**/*.scss',
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
	grunt.loadNpmTasks('grunt-contrib-concat');

	// Default task(s).
	grunt.registerTask('default', ['sass']);
	grunt.registerTask('doJS', ['jshint', 'concat:noBoot']);
	grunt.registerTask('doBuild', ['sass', 'autoprefixer', 'jshint', 'concat:noBoot']);

};
