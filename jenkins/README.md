# Jenkins Pipelines

*For details on how these pipelines are deployed into OpenShift, refer to the [OpenShift documentation](../openshift/README.md)*

*For details on how this project is integrated with SonarQube, refer to the [SonarQube Scanner Integration documentation ](../sonar-runner/README.md)*

The deployed pipelines for this project can be found here; [Pipelines](https://console.pathfinder.gov.bc.ca:8443/console/project/kyrwwq-tools/browse/pipelines)

## Deployment

### Test (`promote-to-test-pipeline`)

This manually triggered pipeline promotes deployments from the `dev` environment to the `test` environment.  To perform the promotion click the **Start Pipeline** on the `promote-to-test-pipeline`.

### Prod (`promote-to-prod-pipeline`)

This manually triggered pipeline promotes deployments from the `test` environment to the `prod` environment.  To perform the promotion click the **Star Pipeline** on the `promote-to-prod-pipeline`.

## Website (`website-pipeline`)

This GitHub webhook triggered pipeline is the main CI/CD pipeline for the project.  It is triggered by each commit to the `master` branch of the [Cullen Commission Website](https://github.com/bcgov/jag-cullencommission) GitHub repository.

This pipeline performs the following operations in sequential order;
- Build the Cullen Commission Website container image.
- Deploy the resulting artifact to the `dev` environment.
- Trigger an asynchronous OWASP ZAP scan on the deployed website.

## SonarQube (`sonarqube-pipeline`)

This GitHub webhook triggered pipeline is the **static** code quality pipeline for the project.  It is triggered by each commit to the `master` branch of the [Cullen Commission Website](https://github.com/bcgov/jag-cullencommission) GitHub repository.

This pipeline performs the following operations in sequential order;
- Performs a static code analysis on the latest source code, providing measures of;
  - Reliability
  - Security
  - Maintainability
  - Duplications
- Uploads the results to the project's SonarQube server.

The results can be found here; [Cullen Commission Website - Code Quality](https://cullen-commission-sonarqube.pathfinder.gov.bc.ca/dashboard?id=CullenCommissionWebsite)

## ZAP (`zap-pipeline`)

This triggered (manually or automatically) pipeline is the OWASP ZAP Scanning pipeline for the project.  It is triggered automatically by the Website (`website-pipeline`) pipeline.

This pipeline performs the following operations in sequential order;
- Performs an OWASP ZAP Scan of the deployed website, providing measures of;
  - Security Vulnerabilities
- Uploads the results to the project's SonarQube server.

The results can be found here; [Cullen Commission Website OWASP ZAP Scan - Issues
](https://cullen-commission-sonarqube.pathfinder.gov.bc.ca/project/issues?id=CullenCommissionWebsite-ZapScan&resolved=false)