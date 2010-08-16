#!/usr/bin/env ruby

require "SimplyCivi/SimplyCivi"
require "SimplyCivi/validator"

# This script will validate the core SimplyCivi files.
#
# The files are not completely valid. This has to do
# with a small number of CSS hacks needed to ensure
# consistent rendering across browsers.
#
# To add your own CSS files for validation, see
# /lib/SimplyCivi/validator.rb

SimplyCivi::Validator.new.validate
