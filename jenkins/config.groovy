// Pipeline Configuration Properties
// Import this file into the pipeline using 'load'.
class config {

  // Wait timeout in minutes
  public static final int WAIT_TIMEOUT = 20

  // Deployment configuration
  public static final String[] DEPLOYMENT_ENVIRONMENT_TAGS = ['dev', 'test', 'prod']
  public static final String DEV_ENV = "${DEPLOYMENT_ENVIRONMENT_TAGS[0]}"
  public static final String TEST_ENV = "${DEPLOYMENT_ENVIRONMENT_TAGS[1]}"
  public static final String PROD_ENV = "${DEPLOYMENT_ENVIRONMENT_TAGS[2]}"

  // The name of the project namespace(s).
  public static final String  NAME_SPACE = '534380'

  // Instance Suffix
  public static final String  SUFFIX = ''

  // Apps - Listed in the order they should be tagged
  public static final String[] APPS = ['website']

  // Build configuration
  public static final String  APP_NAME = "${this.APPS[0]}"
  public static final String[] BUILDS = ["${this.APPS[0]}"]
}

return new config();