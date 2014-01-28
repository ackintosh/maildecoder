# A sample Guardfile
# More info at https://github.com/guard/guard#readme

#guard :phpunit, cmd: "./vendor/bin/phpunit" do
#  watch(%r{^tests/*$})
#end

guard 'phpunit', :tests_path => 'tests', :cli => '--colors' do
  # Watch tests files
  watch(%r{^.+Test\.php$})

  # Watch library files and run their tests
  watch(%r{^source/Mailer/(.+)\.php$}) { |m| "tests/Mailer/#{m[1]}Test.php"}
end
