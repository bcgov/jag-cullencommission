# OpenShift

*For details on the CI/CD pipelines for this project, refer to the [Jenkins documentation](../jenkins/README.md)*

This project uses the [BCDevOps/openshift-developer-tools](https://github.com/BCDevOps/openshift-developer-tools/tree/master/bin) scripts to manage its OpenShift Build and Deployment configurations.  Refer to the associated project documentation for details.

## Prerequisites

The following instructions assume you have installed the [OpenShift scripts](https://github.com/BCDevOps/openshift-developer-tools/blob/master/bin/README.md) and they are accessible via your PATH environment variable.  This scripts run in a GitBash shell.

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

# Installing a Certificate on the Production Route

The [certificate.conf](./certificate.conf) file for this project has already been created to install a certificate and private key on the route of the production deployment.  The gitignore file has also been setup to insure `*.crt` and `*.key` files do not get included in source control.  To install the certificate you will be using the [installCertificate.sh](https://github.com/BCDevOps/openshift-developer-tools/blob/master/bin/installCertificate.sh) from [BCDevOps/openshift-developer-tools](https://github.com/BCDevOps/openshift-developer-tools/tree/master/bin) so make sure you've followed the instructions to install these tools on your machine and they are running.

## Preparing the Private Key

If needed, make a copy of your private key and rename it `private.key`.  Place the file in the `.../jag-cullencommission/openshift` directory (the same directory as the `certificate.conf` file).

## Preparing the Certificate

If you received a certificate via iStore request from the government, it likely came as three separate files (and not as a bundled certificate); `G2Root.txt`, `L1KChain.txt`, and `<yourhostname>.txt`.  We need to install a bundled certificate on the route.

1. Outside the project directory, make a copy of `<yourhostname>.txt` and rename it `Combined.crt`.
2. Using as plain text editor (such as Visual Studio Code), open `Combined.crt` and append the whole content of `L1KChain.txt` to the end of the file.
3. Now append the whole content of `G2Root.txt` to the end of the file.
4. Save the file.  You should have something that looks like this;
```
-----BEGIN CERTIFICATE-----
<YourCertHere>
-----END CERTIFICATE-----
-----BEGIN CERTIFICATE----- 
<IntermediateCert>
-----END CERTIFICATE-----
-----BEGIN CERTIFICATE----- 
<RootCert>
-----END CERTIFICATE-----
```
5. Place the file in the `.../jag-cullencommission/openshift` directory (the same directory as the `certificate.conf` file).

## Installing the Certificate

Open a GitBash shell to the `.../jag-cullencommission/openshift` directory (the same directory as the `certificate.conf` file).

Run the `installCertificate.sh` script, for example;
```
/c/jag-cullencommission/openshift (master)
$ installCertificate.sh -e prod -f certificate.conf
```

## Clean up

Make sure you make secure copies of the bundled certificate `Combined.crt` and private key `private.key` along with any other certificate related files.  Perminently delete all local copies of teh files once you have installed the certificate.