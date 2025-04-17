/**
 * RPG Manager - Script principal
 * Gère les interactions côté client pour l'application RPG Manager
 */

document.addEventListener('DOMContentLoaded', function() {
    // Menu mobile
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const nav = document.querySelector('nav');
    
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            
            // Animation des barres du menu
            const spans = this.querySelectorAll('span');
            spans.forEach(span => {
                span.classList.toggle('active');
            });
        });
    }
    
    // Sélection d'éléments du formulaire
    const classeSelect = document.getElementById('typeClasseId');
    const forceInput = document.getElementById('force');
    const agiliteInput = document.getElementById('agilite');
    const intelligenceInput = document.getElementById('intelligence');
    const pointsDeVieInput = document.getElementById('pointsDeVie');
    const pointsDeMagieInput = document.getElementById('pointsDeMagie');
    
    // Fonction pour marquer un champ comme modifié manuellement
    function markAsModified(inputElement) {
        inputElement.dataset.modified = 'true';
        inputElement.classList.add('user-modified');
    }
    
    // Ajouter des écouteurs pour marquer les champs comme modifiés
    const statInputs = [forceInput, agiliteInput, intelligenceInput, pointsDeVieInput, pointsDeMagieInput];
    statInputs.forEach(input => {
        if (input) {
            input.addEventListener('input', function() {
                markAsModified(this);
            });
        }
    });
    
    // Fonction pour mettre à jour les statistiques selon la classe si on est sur le formulaire
    if (classeSelect) {
        function updateStatsBasedOnClass() {
            const typeClasseId = classeSelect.value;
            
            if (!typeClasseId) return;
            
            // Déterminer le chemin relatif correct pour l'AJAX
            let ajaxPath = 'ajax/get_classe_stats.php';
            if (window.location.href.includes('/views/')) {
                ajaxPath = '../ajax/get_classe_stats.php';
            }
            
            fetch(ajaxPath + '?id=' + typeClasseId)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Erreur:', data.error);
                        return;
                    }
                    
                    // Mise à jour des champs non modifiés
                    if (forceInput && !forceInput.dataset.modified) {
                        forceInput.value = data.force;
                    }
                    
                    if (agiliteInput && !agiliteInput.dataset.modified) {
                        agiliteInput.value = data.agilite;
                    }
                    
                    if (intelligenceInput && !intelligenceInput.dataset.modified) {
                        intelligenceInput.value = data.intelligence;
                    }
                    
                    if (pointsDeVieInput && !pointsDeVieInput.dataset.modified) {
                        pointsDeVieInput.value = data.pointsDeVie;
                    }
                    
                    if (pointsDeMagieInput && !pointsDeMagieInput.dataset.modified) {
                        pointsDeMagieInput.value = data.pointsDeMagie;
                    }
                })
                .catch(error => console.error('Erreur de communication avec le serveur:', error));
        }
        
        // Écouter les changements de classe
        classeSelect.addEventListener('change', updateStatsBasedOnClass);
        
        // Initialiser les statistiques si un type de classe est déjà sélectionné
        if (classeSelect.value) {
            updateStatsBasedOnClass();
        }
    }
    
    // Validation du formulaire
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            // Vérifier que tous les champs requis sont remplis
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });
            
            // Vérifier que les statistiques sont des nombres valides
            const statFields = [forceInput, agiliteInput, intelligenceInput, pointsDeVieInput, pointsDeMagieInput];
            
            statFields.forEach(field => {
                if (field && (isNaN(field.value) || field.value < 1)) {
                    isValid = false;
                    field.classList.add('error');
                }
            });
            
            if (!isValid) {
                event.preventDefault();
                alert('Veuillez remplir correctement tous les champs du formulaire.');
            }
        });
    }
    
    // Effet visuel pour les cartes de personnages
    const characterCards = document.querySelectorAll('.character-card');
    if (characterCards.length > 0) {
        characterCards.forEach(card => {
            card.addEventListener('mouseover', function() {
                this.classList.add('card-hover');
            });
            
            card.addEventListener('mouseout', function() {
                this.classList.remove('card-hover');
            });
        });
    }
    
    // Animation pour les messages
    const messages = document.querySelectorAll('.message');
    if (messages.length > 0) {
        setTimeout(() => {
            messages.forEach(message => {
                message.style.opacity = '0';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 500);
            });
        }, 5000);
    }
    
    // Animation d'entrée pour la section héros
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        heroSection.classList.add('fade-in');
    }
    
    // Animation pour les lignes de démonstration de polymorphisme
    const demoLines = document.querySelectorAll('.demo-line');
    if (demoLines.length > 0) {
        demoLines.forEach((line, index) => {
            setTimeout(() => {
                line.classList.add('animate-in');
            }, 300 + (index * 200));
        });
    }
});