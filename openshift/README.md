# OpenShift

*For details on the CI/CD pipelines for this project, refer to the [Jenkins documentation](../jenkins/README.md)*

This project uses the [BCDevOps/openshift-developer-tools](https://github.com/BCDevOps/openshift-developer-tools/tree/master/bin) scripts to manage its OpenShift Build and Deployment configurations.  Refer to the associated project documentation for details.

## Prerequisites

The following instructions assume you have installed the [OpenShift scripts](https://github.com/BCDevOps/openshift-developer-tools/blob/master/bin/README.md) and they are accessible via your PATH environment variable.

*All* commands are executed from the project's `./openshift` directory.

# `Settings.sh` file

This file defines the base name of your OpenShift project set along with the project's GitHub repository URL and working branch.

# Initial Project Setup

*This process only needs to be performed once when initially setting up a newly provisioned project set.*  **If you are working with an existing project set you can ignore this section.**

When initially setting up newly provisioned OpenShift project set you need to configure the project policies to allow the deployment environments to monitor and pull images from your `tools` project and allow the Jenkins service account in the `tools` project to monitor deployments in you deployment projects.

The `initOSProjects.sh` automates this process.  Simply run it once on a newly provisioned project set and it will handle the rest.

# Parameter `.param` Management

Run the `genParams.sh` whenever a new template is created or a change adds or modifies a template parameter.  The same goes for adding new Jenkins files (pipelines).

```
genParams.sh
genParams.sh -h     # Display full help documentation for the script.
```

- The `-f` flag can be used to update existing parameter files.
- The `-c <componentName>` flag can be used to limit the scope of the create/update to a given component's templates and Jenkins files.

Deployment parameter files come in sets of four allowing you to have specific settings for each environment;
- The defaults: `*.param`
- The parameters for the `dev` environment: `*.dev.param`
- The parameters for the `test` environment: `*.test.param`
- The parameters for the `prod` environment: `*.prod.param`

The defaults are always applied first, uncommented values in subsiquent param files then override the default values.

# Publishing/Updating Build Configurations

Once you have your `.param` files you can publish (deploy) or update your builds and pipelines on OpenShift.

```
genBuilds.sh        # when you want to publish (deploy) a new build or pipeline artifact.
genBuilds.sh -u     # when you have modified your build templates or parameter files and want to update the related artifact(s).
genBuilds.sh -h     # Display full help documentation for the script.
```

- The `-c <componentName>` flag can be used to limit the scope of the create/update to a given components template's and Jenkins files.

*Use caution when updating builds and pipelines as it can affect the webhook URLs resulting in a disconnect between GitHub and the build.*

# Publishing/Updating Deployment Configurations
 
```
genDepls.sh         # when you want to publish (deploy) a new deployment artifact.
genDepls.sh -u      # when you have modified your deployment templates or parameter files and want to update the related artifact(s).
genDepls.sh -h      # Display full help documentation for the script.
```

- The `-c <componentName>` flag can be used to limit the scope of the create/update to a given components template's.
- The `-e <environmentName>` flag can be used to target an environment (for example, `test` or `prod`) other than `dev`.