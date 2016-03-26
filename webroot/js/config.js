requirejs.config({
	baseUrl: '/js',
	paths: {
		jquery: 'vendor/jquery/dist/jquery',
		angular: 'vendor/angular/angular',
		bootstrap: ['//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.', 'libs/bootstrap-min']
    },
	},
	shim: {
		angular: {
			exports: 'angular'
		},

   	bootstrap : ['jquery']
	},
	packages: [

	]
});

requirejs(["main"]);
