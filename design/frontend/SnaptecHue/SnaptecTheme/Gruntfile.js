module.exports = function(grunt) {

  grunt.initConfig({
      pkg: grunt.file.readJSON('package.json'),
      watch: {
          styles: {
              files: ['app/design/frontend/SnaptecHue/SnaptecTheme/web/css/custom.css'],
              tasks: ['less', 'cssmin'],
              options: {
                  livereload: true
              }
          },
          options: {
              interrupt: true,
              spawn: false,
              debounceDelay: 250,
              reload: true,
              forever: true,
              atBegin: true
          }
      }
  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch');
  
  grunt.registerTask('default', ['watch']);

  console.log('watching');
};