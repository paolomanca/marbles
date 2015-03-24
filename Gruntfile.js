module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            options: {
                includePaths: ['bower_components/foundation/scss', 'bower_components/compass-mixins/lib', 'bower_components/fontawesome/scss']
            },
            dist: {
                options: {
                    outputStyle: 'expanded'
                },
                files: {
                    'css/style.css': 'scss/style.scss'
                }
            }
        },

        cssmin: {
            minify: {
                files: {
                    'css/style.min.css': 'css/style.css'
                }
            }
        },

        uglify: {
            foo: {
                files: {
                    'js/head.js': ['js/head/*.js'],
                    'js/foot.js': ['js/foot/*.js']
                }
            }

        },

        copy: {
            cp_bower: {
                files: [
                    {
                        expand: true,
                        flatten: true,
                        src: ['bower_components/modernizr/modernizr.js'],
                        dest: 'js/head'
                    },
                    {
                        expand: true,
                        flatten: true,
                        src: ['bower_components/foundation/js/foundation.js'],
                        dest: 'js/foot'
                    }
                ]
            }
        },

        markdown: {
            all: {
                files: [{
                    expand: true,
                    src: '*.md',
                    ext: '.html'
                }]
            }
        },

        watch: {
            grunt: {files: ['Gruntfile.js']},

            sass: {
                files: 'scss/**/*.scss',
                tasks: ['sass']
            },

            cssmin: {
                files: ['css/*.css', '!css/*.min.css'],
                tasks: ['cssmin']
            },

            uglify: {
                files: ['js/*/*.js'],
                tasks: ['uglify']
            },

            copy: {
                files: ['bower_components/{foundation,modernizr}/**/*.js'],
                tasks: ['copy']
            },

            markdown: {
                files: ['*.md'],
                tasks: ['markdown']
            }
        }
    });

    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-markdown');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('build', ['copy', 'sass', 'cssmin', 'uglify', 'markdown']);
    grunt.registerTask('default', ['build', 'watch']);
}
