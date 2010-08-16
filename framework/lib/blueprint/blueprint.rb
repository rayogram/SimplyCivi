require 'fileutils'
module SimplyCivi
  # path to the root SimplyCivi directory
  ROOT_PATH =             File.join(File.expand_path(File.dirname(__FILE__)), "../../")
  # path to where the SimplyCivi CSS files are stored
  SimplyCivi_ROOT_PATH =   File.join(SimplyCivi::ROOT_PATH, "SimplyCivi")
  # path to where the SimplyCivi CSS raw CSS files are stored
  SOURCE_PATH =           File.join(SimplyCivi::SimplyCivi_ROOT_PATH, "src")
  # path to where the SimplyCivi CSS generated test files are stored
  TEST_PATH =             File.join(SimplyCivi::ROOT_PATH, "tests")
  # path to the root of the SimplyCivi scripts
  LIB_PATH =              File.join(SimplyCivi::ROOT_PATH, "lib", "SimplyCivi")
  # path to where SimplyCivi plugins are stored
  PLUGINS_PATH =          File.join(SimplyCivi::SimplyCivi_ROOT_PATH, "plugins")
  # settings YAML file where custom user settings are saved
  SETTINGS_FILE =         File.join(SimplyCivi::ROOT_PATH, "lib", "settings.yml")
  # path to validator jar file to validate generated CSS files
  VALIDATOR_FILE =        File.join(SimplyCivi::LIB_PATH, "validate", "css-validator.jar")
  # hash of compressed and source CSS files
  CSS_FILES = {
    "screen.css"   => ["reset.css", "typography.css", "forms.css", "grid.css"],
    "print.css"    => ["print.css"],
    "ie.css"       => ["ie.css"]
  }

  # default number of columns for SimplyCivi layout
  COLUMN_COUNT =          24
  # default column width (in pixels) for SimplyCivi layout
  COLUMN_WIDTH =          30
  # default gutter width (in pixels) for SimplyCivi layout
  GUTTER_WIDTH =          10
  
  INPUT_PADDING =         5
  INPUT_BORDER =          1
end

Dir["#{File.join(SimplyCivi::LIB_PATH)}/*"].each do |file|
  require file if file =~ /\.rb$/ && file !~ /SimplyCivi\.rb/
end
