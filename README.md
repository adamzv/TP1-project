# TP1-project [![Build status](https://dev.azure.com/adamzv/TP1-project/_apis/build/status/TP1-project-CI)](https://dev.azure.com/adamzv/TP1-project/_build/latest?definitionId=3)


Team project focused on developing event based calendar for university using Vue.js, Laravel and Docker for deployment.

## Deployment
We are using Azure DevOps for CI/CD and after successful build, services are automatically deployed to our Azure VM running Ubuntu 18.04 (Standard B1ms (1 vcpus, 2 GiB memory)).

## IP addresses
* frontend - http://40.127.143.10:8080
* backend - http://40.127.143.10:3000

In the future ports will be changed to ensure proper communication between frontend and backend

## Authors
* [Adam Zverka](https://github.com/adamzv) - team leader, continuous integration and deployment, frontend
* [Kristián Kluka](https://github.com/kristiankluka) - backend, SW architect related tasks
* [Ľudovít Laca](https://github.com/Ludovit-Laca) - backend, DB design
* [Martin Gajdoš](https://github.com/martingajdos) - design, frontend
