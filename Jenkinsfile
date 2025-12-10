pipeline {
    agent any

    // 1. ESTO ASEGURA LA AUTOMATIZACIÓN (Revisa cada minuto)
    triggers {
        pollSCM '* * * * *'
    }

    environment {
        // Asegúrate que 'sonar-token' sea el ID correcto en tus credenciales de Jenkins
        SONAR_AUTH_TOKEN = credentials('sonar-token')
    }

    stages {

        stage('Checkout') {
            steps {
                echo "Descargando código desde GitHub..."
                checkout scm
            }
        }

        stage('Build & Docker') {
            steps {
                echo "Construyendo imagen Docker..."
                // 2. AQUÍ ESTÁ EL COMANDO QUE FALTABA
                // '-t proyecto-semestral' le pone nombre a tu imagen
                // El punto final '.' es importante (significa "aquí")
                sh 'docker build -t proyecto-semestral:v1 .'
            }
        }

        stage('SonarQube Analysis') {
            steps {
                echo "Ejecutando análisis en SonarQube..."
                
                // OJO: Mantengo 'sonar-sever' porque así lo tienes en tu Jenkins (según tu foto anterior)
                // Si ya lo corregiste a 'sonar-server', cambia esta línea.
                withSonarQubeEnv('sonar-sever') { 

                    script {
                        def scannerHome = tool 'sonar-scanner'

                        withEnv(["PATH+SONAR=${scannerHome}/bin"]) {
                            sh """
                                sonar-scanner \
                                -Dsonar.projectKey=semestral-ciberv \
                                -Dsonar.sources=. \
                                -Dsonar.host.url=http://192.168.80.147:9000 \
                                -Dsonar.login=$SONAR_AUTH_TOKEN
                            """
                        }
                    }
                }
            }
        }
    }
}
