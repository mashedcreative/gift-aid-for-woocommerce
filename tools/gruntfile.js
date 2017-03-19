module.exports = function(grunt) {
	require('load-grunt-config')(grunt, {
		init: true,
		jitGrunt: {
			jitGrunt: true,
			// -------------------------------------
			// These static mappings help Grunt play
			// nicely with certain plugins.
			// -------------------------------------
			staticMappings: {
				sasslint:    'grunt-sass-lint',
				sprite:      'grunt-spritesmith',
			}
		},
		// -----------------------------------------------------------------------------
		// Anything you define within the main 'data' object can be accessed
		// both in the Gruntfile and in the individual task configurations e.g.
		// <%= pluginInfo.assets_path_raw %> etc.
		// -----------------------------------------------------------------------------
		data: {
			// -------------------------------------
			// Project specific settings.
			// -------------------------------------
			pluginInfo: {
				// -------------------------------------
				// The 'fancy' name for your plugin
				// e.g. 'My First Plugin'.
				// -------------------------------------
				fancy_name: 'Plugin Name',

				// -------------------------------------
				// Documentation path relative to the
				// plugin root - NO trailing slash.
				// -------------------------------------
				docs_path: 'tools/docs',

				// -------------------------------------
				// Reports path relative to the plugin
				// root - NO trailing slash.
				// -------------------------------------
				reports_path: 'tools/reports',

				// -------------------------------------
				// Reports path relative to the plugin
				// root - NO trailing slash.
				// -------------------------------------
				tests_path: 'tools/tests',

				// -------------------------------------
				// Assets path relative to the plugin
				// root - NO trailing slash.
				// -------------------------------------
				assets_path_dev: 'assets/dev',
				assets_path_prod: 'assets/prod',

				// -------------------------------------
				// Image assets directory.
				// -------------------------------------
				img_dir: 'img',

				// -------------------------------------
				// Javascript assets directory.
				// -------------------------------------
				js_dir: 'js',

				// -------------------------------------
				// SCSS assets directory.
				// -------------------------------------
				scss_dir: 'scss',

				// -------------------------------------
				// CSS assets directory.
				// -------------------------------------
				css_dir: 'css',

				// -------------------------------------
				// Name of your main Sass file and
				// consequent CSS file.
				// -------------------------------------
				admin_scss_file: 'admin',
				public_scss_file: 'public'
			},

			// -------------------------------------
			// Array of paths to Javascript files
			// for PUBLIC enqueues.
			// -------------------------------------
			concatPublic: [
				'<%= pluginInfo.assets_path_dev %>/<%= pluginInfo.js_dir %>/lib/_modernizr_custom.js',
				'<%= pluginInfo.assets_path_dev %>/<%= pluginInfo.js_dir %>/public.js'
			],

			// -------------------------------------
			// Array of paths to Javascript files
			// for ADMIN enqueues.
			// -------------------------------------
			concatAdmin: [
				'<%= pluginInfo.assets_path_dev %>/<%= pluginInfo.js_dir %>/admin.js'
			],

			// -------------------------------------
			// Array of paths to Javascript files
			// for CUSTOMIZER enqueues.
			// -------------------------------------
			concatCustomizer: [
				'<%= pluginInfo.assets_path_dev %>/<%= pluginInfo.js_dir %>/customizer.js'
			],

			// -------------------------------------
			// Array of objects that have Bower `src`
			// and theme `dest` paths to facilitate
			// syncing of files and/or folders.
			//
			// There is no need for `bower_components`
			// in the `src` if you specify `cwd` in
			// the object. This is useful if you wish
			// to define multiple `src` paths.
			//
			// If you need to sync a directory in
			// its entirety, append `/**` to the
			// path to the source directory.
			//
			// Finally, remember the `dest` path is
			// relative to the plugin root, not the
			// `cwd` if specified.
			// -------------------------------------
			syncAssets: [
				// -------------------------------------
				// Example to use as basis for any new
				// Bower folder/file syncing.
				//
				// {
				//     cwd: 'bower_components',
				//     src: ['path/**'],
				//     dest: 'dest/'
				// }
				// -------------------------------------
			]
		}
	});
	// -----------------------------------------------------------------------------
	// Provides a summary of the time tasks have taken.
	// -----------------------------------------------------------------------------
	require('time-grunt')(grunt);

	grunt.file.setBase( '../' );

	// -----------------------------------------------------------------------------
	// Silences grunt-newer.
	// https://github.com/tschaub/grunt-newer/issues/52#issuecomment-59397284
	// -----------------------------------------------------------------------------
	var origLogHeader = grunt.log.header;
	grunt.log.header = function( msg ) {
		if ( !/newer(-postrun)?:/.test( msg ) ) {
			origLogHeader.apply( this, arguments );
		}
	};
};
