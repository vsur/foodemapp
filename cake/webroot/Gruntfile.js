//Gruntfile.js
var sass = require('node-sass');
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
		sass: {                             
			options: { implementation: sass, sourceMap: true },
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
				reporter: require('jshint-stylish'),
				"esversion": 6
			},

			// when this task is run, lint the Gruntfile and all js files in src
			all: ['Gruntfile.js', '!javascripts/bootstrap*.js', 'javascripts/fmapp_app.js', 'javascripts/fmapp_beta_app.js', 'javascripts/filterwheelsunburst.js', 'javascripts/heatmap-std.js', 'javascripts/heatmap-map.js']
		},

		concat: {
			basic: {
				src: ['javascripts/bootstrap.js', 'javascripts/fmapp_app.js'],
				dest: 'js/boot_fmapp_app.js',
			},
			noBoot: {
				src: ['javascripts/fmapp_app.js'],
				dest: 'js/fmapp_app.js',
			},
			noBootBeta: {
                src: ['javascripts/fmapp_beta_app.js'],
                dest: 'js/fmapp_beta_app.js'
            },
			componentWheel: {
				src: ['javascripts/componentwheelsunburst.js'],
				dest: 'js/componentwheelsunburst.js',
			},
			chord: {
				src: ['javascripts/chord-diagram.js'],
				dest: 'js/chord-diagram.js',
			},
			leafletMap: {
				src: ['javascripts/leaflet-map.js'],
				dest: 'js/leaflet-map.js',
			},
			heatmap: {
				src: ['javascripts/heatmap-std.js'],
				dest: 'js/heatmap-std.js',
			},
			heatmapMap: {
				src: ['javascripts/heatmap-map.js'],
				dest: 'js/heatmap-map.js',
			}

		},

		// Config watch
		// Keep on
		watch: {
			scripts: {
				files: ['javascripts/*.js'],
				tasks: ['jshint', 'concat:noBootBeta', 'concat:componentWheel', 'concat:chord', 'concat:leafletMap', 'concat:heatmap', 'concat:heatmapMap'],
				options: {
					spawn: false
				},
			},
			css: {
				files: '**/*.scss',
				tasks: ['sass'],
				options: {
					livereload: true
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
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-html');
	grunt.loadNpmTasks('grunt-sass');
	
	// Default task(s).
	grunt.registerTask('default', ['sass']);
	grunt.registerTask('doJS', ['jshint', 'concat:noBoot']);
	grunt.registerTask('doBuild', ['sass', 'autoprefixer', 'jshint', 'concat:noBoot', 'concat:noBootBeta']);

};
