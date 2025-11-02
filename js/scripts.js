/**
 * Scripts JavaScript interactifs pour le projet TD3
 * Gère les animations, tooltips, confirmations et améliorations UX
 * 
 * @package TD3
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */

(function() {
    'use strict';

    /**
     * Initialisation du script au chargement du DOM
     */
    document.addEventListener('DOMContentLoaded', function() {
        initTooltips();
        initAnimations();
        initConfirmations();
        initFormValidation();
        initAddressAutocomplete();
        initSmoothScrolling();
        initTableEnhancements();
        initAlertBoxes();
    });

    /**
     * Initialise les tooltips pour les boutons d'action
     */
    function initTooltips() {
        // Les tooltips sont gérés par CSS, mais on peut ajouter des améliorations
        const actionButtons = document.querySelectorAll('.action-btn');
        
        actionButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    }

    /**
     * Initialise les animations d'apparition
     */
    function initAnimations() {
        // Animation d'apparition pour les éléments du tableau
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 50);
                }
            });
        }, observerOptions);

        // Observer les lignes du tableau
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';
            row.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            observer.observe(row);
        });

        // Observer les cartes
        const cards = document.querySelectorAll('.carte');
        cards.forEach(card => {
            observer.observe(card);
        });
    }

    /**
     * Améliore les confirmations de suppression
     */
    function initConfirmations() {
        const deleteButtons = document.querySelectorAll('.action-btn-delete, a[onclick*="confirm"]');
        
        deleteButtons.forEach(button => {
            // Retirer l'attribut onclick existant
            if (button.hasAttribute('onclick')) {
                button.removeAttribute('onclick');
            }
            
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                const href = this.href;
                
                if (!href || href === '#') {
                    return;
                }

                // Créer une modale de confirmation sophistiquée
                showConfirmationModal(
                    'Confirmer la suppression',
                    'Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.',
                    'Supprimer',
                    'Annuler'
                ).then(confirmed => {
                    if (confirmed) {
                        // Ajouter une animation de chargement
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                        this.style.pointerEvents = 'none';
                        
                        // Rediriger après un court délai pour l'animation
                        setTimeout(() => {
                            window.location.href = href;
                        }, 300);
                    }
                });
            });
        });
    }

    /**
     * Affiche une modale de confirmation personnalisée
     * 
     * @param {string} title - Titre de la modale
     * @param {string} message - Message de confirmation
     * @param {string} confirmText - Texte du bouton de confirmation
     * @param {string} cancelText - Texte du bouton d'annulation
     * @returns {boolean} - True si confirmé, false sinon
     */
    function showConfirmationModal(title, message, confirmText, cancelText) {
        // Créer l'overlay
        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10000;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        `;

        // Créer la modale
        const modal = document.createElement('div');
        modal.style.cssText = `
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 90%;
            animation: slideUp 0.3s ease;
        `;

        modal.innerHTML = `
            <h3 style="margin: 0 0 15px 0; color: #111827; font-weight: 600;">${title}</h3>
            <p style="margin: 0 0 25px 0; color: #4b5563; line-height: 1.5;">${message}</p>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button id="modal-cancel" style="
                    padding: 10px 20px;
                    border: 2px solid #e5e7eb;
                    background: white;
                    border-radius: 8px;
                    cursor: pointer;
                    font-weight: 600;
                    transition: all 0.2s;
                ">${cancelText}</button>
                <button id="modal-confirm" style="
                    padding: 10px 20px;
                    border: none;
                    background: linear-gradient(135deg, #ef4444, #dc2626);
                    color: white;
                    border-radius: 8px;
                    cursor: pointer;
                    font-weight: 600;
                    transition: all 0.2s;
                ">${confirmText}</button>
            </div>
        `;

        overlay.appendChild(modal);
        document.body.appendChild(overlay);

        // Ajouter les styles d'animation si ils n'existent pas déjà
        if (!document.getElementById('modal-animation-style')) {
            const style = document.createElement('style');
            style.id = 'modal-animation-style';
            style.textContent = `
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
                @keyframes slideUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                @keyframes fadeOut {
                    from { opacity: 1; }
                    to { opacity: 0; }
                }
                @keyframes slideDown {
                    from {
                        opacity: 1;
                        transform: translateY(0);
                    }
                    to {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                }
                #modal-cancel:hover {
                    background: #f3f4f6;
                    transform: translateY(-2px);
                }
                #modal-confirm:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
                }
            `;
            document.head.appendChild(style);
        }

        // Gérer les clics
        return new Promise((resolve) => {
            const confirmBtn = document.getElementById('modal-confirm');
            const cancelBtn = document.getElementById('modal-cancel');
            
            const closeModal = (confirmed) => {
                overlay.style.animation = 'fadeOut 0.2s ease';
                modal.style.animation = 'slideDown 0.2s ease';
                setTimeout(() => {
                    if (overlay.parentElement) {
                        document.body.removeChild(overlay);
                    }
                    // Ne pas supprimer le style, il peut être réutilisé
                }, 200);
                resolve(confirmed);
            };

            confirmBtn.addEventListener('click', () => {
                closeModal(true);
            });

            cancelBtn.addEventListener('click', () => {
                closeModal(false);
            });

            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    closeModal(false);
                }
            });
        });
    }

    /**
     * Initialise la validation des formulaires
     */
    function initFormValidation() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const inputs = form.querySelectorAll('input[required], select[required]');
                let isValid = true;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.borderColor = '#ef4444';
                        input.style.animation = 'shake 0.5s ease';
                        
                        // Retirer le style après l'animation
                        setTimeout(() => {
                            input.style.borderColor = '';
                            input.style.animation = '';
                        }, 500);
                    } else {
                        input.style.borderColor = '#22c55e';
                        setTimeout(() => {
                            input.style.borderColor = '';
                        }, 1000);
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    showNotification('Veuillez remplir tous les champs requis', 'error');
                }
            });
        });

        // Ajouter l'animation shake si elle n'existe pas déjà
        if (!document.getElementById('shake-animation-style')) {
            const style = document.createElement('style');
            style.id = 'shake-animation-style';
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    25% { transform: translateX(-10px); }
                    75% { transform: translateX(10px); }
                }
            `;
            document.head.appendChild(style);
        }
    }

    /**
     * Initialise le défilement fluide
     */
    function initSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    /**
     * Améliore l'affichage des tableaux
     */
    function initTableEnhancements() {
        const tables = document.querySelectorAll('.w3-table-all, .w3-table');
        
        tables.forEach(table => {
            // Ajouter un effet de survol sur les lignes
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach((row, index) => {
                row.style.transition = 'all 0.2s ease';
                
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = 'rgba(37, 99, 235, 0.05)';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });
    }

    /**
     * Initialise la gestion des boîtes d'alerte
     */
    function initAlertBoxes() {
        const closeButtons = document.querySelectorAll('.closebtn');
        
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alertbox = this.parentElement;
                alertbox.style.opacity = '0';
                alertbox.style.transform = 'translateX(400px)';
                setTimeout(() => {
                    alertbox.style.display = 'none';
                }, 600);
            });
        });

        // Fermer automatiquement après 5 secondes
        const alertboxes = document.querySelectorAll('.alertbox');
        alertboxes.forEach(alertbox => {
            setTimeout(() => {
                if (alertbox.style.display !== 'none') {
                    alertbox.style.opacity = '0';
                    alertbox.style.transform = 'translateX(400px)';
                    setTimeout(() => {
                        alertbox.style.display = 'none';
                    }, 600);
                }
            }, 5000);
        });
    }

    /**
     * Affiche une notification
     * 
     * @param {string} message - Message à afficher
     * @param {string} type - Type de notification (success, error, info)
     */
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alertbox ${type === 'error' ? 'errorbox' : 'messagebox'}`;
        notification.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            min-width: 300px;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            animation: slideInRight 0.4s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        `;

        notification.innerHTML = `
            <span>${message}</span>
            <span class="closebtn" style="cursor: pointer; font-size: 20px; font-weight: bold; opacity: 0.8;">&times;</span>
        `;

        document.body.appendChild(notification);

        const closeBtn = notification.querySelector('.closebtn');
        closeBtn.addEventListener('click', () => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.parentElement.removeChild(notification);
                }
            }, 600);
        });

        // Fermer automatiquement après 5 secondes
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.parentElement.removeChild(notification);
                    }
                }, 600);
            }
        }, 5000);
    }

    /**
     * Initialise l'autocomplétion d'adresse avec validation
     * Utilise l'API Nominatim (OpenStreetMap) pour rechercher les adresses
     * Fonctionne en temps réel comme Google Maps
     */
    function initAddressAutocomplete() {
        console.log('🔍 Initialisation de l\'autocomplétion d\'adresse...');
        
        // Fonction pour initialiser un champ d'adresse
        function setupAddressInput(addressInput) {
            const form = addressInput.closest('form');
            const zipcodeInput = form ? form.querySelector('input[name="zipcode"]') : null;
            const townInput = form ? form.querySelector('input[name="town"]') : null;
            
            if (!zipcodeInput || !townInput) {
                console.warn('⚠️ Champs zipcode ou town introuvables pour:', addressInput);
                return;
            }
            
            console.log('✅ Configuration de l\'autocomplétion pour:', addressInput);
            
            // S'assurer que le parent est en position relative
            const parent = addressInput.parentNode;
            if (parent) {
                const computedStyle = window.getComputedStyle(parent);
                if (computedStyle.position === 'static') {
                    parent.style.position = 'relative';
                    parent.style.zIndex = '1000';
                }
            }
            
            let timeout;
            let suggestionsList = null;
            let isSearching = false;
            
                // Créer la liste de suggestions
                function createSuggestionsList() {
                // Supprimer l'ancienne liste si elle existe
                const existing = addressInput.parentNode.querySelector('.address-suggestions');
                if (existing) {
                    existing.remove();
                }
                
                const list = document.createElement('ul');
                list.className = 'address-suggestions';
                list.style.display = 'none';
                addressInput.parentNode.appendChild(list);
                return list;
            }
            
            function hideSuggestions() {
                if (suggestionsList) {
                    suggestionsList.style.display = 'none';
                    suggestionsList.innerHTML = '';
                }
            }
            
            function showSuggestions(suggestions) {
                if (!suggestionsList) {
                    suggestionsList = createSuggestionsList();
                }
                
                suggestionsList.innerHTML = '';
                
                if (suggestions.length === 0) {
                    hideSuggestions();
                    return;
                }
                
                suggestions.forEach(suggestion => {
                    const li = document.createElement('li');
                    
                    // Formater l'affichage de l'adresse
                    const address = suggestion.address || {};
                    const displayParts = [];
                    
                    if (address.road) displayParts.push(address.road);
                    if (address.postcode) displayParts.push(address.postcode);
                    if (address.city || address.town || address.village) {
                        displayParts.push(address.city || address.town || address.village);
                    }
                    
                    const displayText = displayParts.length > 0 
                        ? displayParts.join(', ') 
                        : suggestion.display_name;
                    
                    li.innerHTML = `<i class="fas fa-map-marker-alt" style="margin-right: 8px; color: var(--primary-blue);"></i>${displayText}`;
                    li.addEventListener('click', () => {
                        // Extraire l'adresse complète (rue + numéro)
                        const fullAddress = address.road 
                            ? (address.house_number ? address.house_number + ' ' + address.road : address.road)
                            : suggestion.display_name.split(',')[0];
                        
                        console.log('✅ Adresse sélectionnée:', fullAddress);
                        addressInput.value = fullAddress || '';
                        if (zipcodeInput) {
                            zipcodeInput.value = address.postcode || '';
                            console.log('📍 Code postal:', address.postcode);
                        }
                        if (townInput) {
                            const city = address.city || address.town || address.village || '';
                            townInput.value = capitalizeFirst(city);
                            console.log('🏙️ Ville:', city);
                        }
                        hideSuggestions();
                    });
                    suggestionsList.appendChild(li);
                });
                
                suggestionsList.style.display = 'block';
            }
            
            // Fonction pour afficher les suggestions de l'API Adresse Data Gouv
            function showSuggestionsFromDataGouv(features) {
                if (!suggestionsList) {
                    suggestionsList = createSuggestionsList();
                }
                
                suggestionsList.innerHTML = '';
                
                if (features.length === 0) {
                    hideSuggestions();
                    return;
                }
                
                features.forEach((feature) => {
                    const li = document.createElement('li');
                    const props = feature.properties || {};
                    
                    // Formater l'affichage : numéro + nom de rue, code postal, ville
                    const displayParts = [];
                    if (props.housenumber && props.street) {
                        displayParts.push(props.housenumber + ' ' + props.street);
                    } else if (props.street) {
                        displayParts.push(props.street);
                    } else if (props.name) {
                        displayParts.push(props.name);
                    }
                    
                    if (props.postcode) displayParts.push(props.postcode);
                    if (props.city) displayParts.push(props.city);
                    
                    const displayText = displayParts.length > 0 
                        ? displayParts.join(', ') 
                        : props.label || props.name || 'Adresse inconnue';
                    
                    li.innerHTML = `<i class="fas fa-map-marker-alt" style="margin-right: 8px; color: var(--primary-blue);"></i>${displayText}`;
                    li.addEventListener('click', () => {
                        // Remplir les champs
                        const fullAddress = (props.housenumber ? props.housenumber + ' ' : '') + (props.street || props.name || '');
                        
                        console.log('✅ Adresse sélectionnée:', fullAddress);
                        addressInput.value = fullAddress || '';
                        if (zipcodeInput) {
                            zipcodeInput.value = props.postcode || '';
                            console.log('📍 Code postal:', props.postcode);
                        }
                        if (townInput) {
                            const city = props.city || '';
                            townInput.value = capitalizeFirst(city);
                            console.log('🏙️ Ville:', city);
                        }
                        hideSuggestions();
                    });
                    suggestionsList.appendChild(li);
                });
                
                suggestionsList.style.display = 'block';
                console.log('✅ Suggestions affichées');
            }
            
            // Fonction pour capitaliser la première lettre
            function capitalizeFirst(str) {
                if (!str) return '';
                return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
            }
            
            // Recherche d'adresse avec API Nominatim
            function searchAddress(query) {
                const trimmedQuery = query.trim();
                
                if (trimmedQuery.length < 2) {
                    hideSuggestions();
                    return;
                }
                
                if (isSearching) return; // Éviter les recherches multiples simultanées
                isSearching = true;
                
                // Créer la liste si elle n'existe pas
                if (!suggestionsList) {
                    suggestionsList = createSuggestionsList();
                }
                
                // S'assurer que la liste est visible avant de chercher
                if (suggestionsList.style.display === 'none') {
                    suggestionsList.style.display = 'block';
                }
                
                // Afficher un indicateur de chargement
                suggestionsList.innerHTML = '<li style="color: #666; cursor: default; padding: 12px 20px; display: flex; align-items: center;"><i class="fas fa-spinner fa-spin" style="margin-right: 10px; color: var(--primary-blue);"></i> Recherche en cours...</li>';
                
                // Utiliser l'API Adresse Data Gouv (API française officielle) qui supporte mieux CORS
                // Cette API ne nécessite pas de proxy et fonctionne directement depuis le navigateur
                // L'API cherche automatiquement uniquement en France
                const apiUrl = `https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(trimmedQuery)}&limit=10&autocomplete=1`;
                
                console.log('🌐 Requête API Adresse Data Gouv:', apiUrl);
                
                // Utiliser fetch avec gestion d'erreur
                fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    mode: 'cors'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau: ' + response.status);
                    }
                    return response.json();
                })
                .then(result => {
                    isSearching = false;
                    
                    // L'API Adresse Data Gouv retourne { features: [...] }
                    const data = result.features || [];
                    
                    console.log('✅ Résultats reçus:', data.length, 'adresses');
                    
                    if (data.length > 0) {
                        console.log(`📌 ${data.length} résultats trouvés`);
                        showSuggestionsFromDataGouv(data);
                    } else {
                        console.log('❌ Aucun résultat');
                        // Afficher un message si aucun résultat
                        if (suggestionsList) {
                            suggestionsList.innerHTML = '<li style="color: #999; cursor: default; padding: 12px 20px; font-style: italic;"><i class="fas fa-search" style="margin-right: 8px;"></i>Aucun résultat trouvé. Continuez à taper...</li>';
                            suggestionsList.style.display = 'block';
                        }
                    }
                })
                .catch(error => {
                    isSearching = false;
                    
                    // Afficher un message d'erreur dans la liste
                    if (suggestionsList) {
                        suggestionsList.innerHTML = '<li style="color: #ef4444; cursor: default; padding: 12px 20px;"><i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i>Erreur de connexion. Vérifiez votre connexion internet.</li>';
                        suggestionsList.style.display = 'block';
                        setTimeout(() => hideSuggestions(), 3000);
                    }
                    
                    // Ne pas réessayer automatiquement pour éviter les boucles infinies
                });
            }
            
            // Écouter les changements dans le champ adresse - en temps réel
            addressInput.addEventListener('input', function(e) {
                clearTimeout(timeout);
                const query = this.value.trim();
                
                console.log('📝 Saisie dans le champ adresse:', query);
                
                // Démarrer la recherche dès 2 caractères
                if (query.length >= 2) {
                    // Créer la liste si elle n'existe pas encore
                    if (!suggestionsList) {
                        suggestionsList = createSuggestionsList();
                        console.log('📋 Liste de suggestions créée');
                    }
                    
                    // Afficher immédiatement un indicateur visuel
                    suggestionsList.innerHTML = '<li style="color: #999; cursor: default; padding: 12px 20px; font-style: italic;"><i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>Recherche...</li>';
                    suggestionsList.style.display = 'block';
                    
                    // Délai pour éviter trop de requêtes
                    timeout = setTimeout(() => {
                        const currentValue = addressInput.value.trim();
                        if (currentValue.length >= 2) {
                            console.log('🔎 Lancement de la recherche pour:', currentValue);
                            searchAddress(currentValue);
                        } else {
                            hideSuggestions();
                        }
                    }, 300);
                } else {
                    hideSuggestions();
                }
            });
            
            // Écouter aussi les événements keyup pour être encore plus réactif
            addressInput.addEventListener('keyup', function(e) {
                // Ne pas déclencher sur les touches de navigation
                if (['ArrowDown', 'ArrowUp', 'Enter', 'Escape', 'Tab'].includes(e.key)) {
                    return;
                }
                
                const query = this.value;
                if (query.length >= 2) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        searchAddress(query);
                    }, 100);
                }
            });
            
            // Réafficher les suggestions si on revient sur le champ avec du texte
            addressInput.addEventListener('focus', function() {
                const query = this.value.trim();
                if (query.length >= 2) {
                    if (!suggestionsList) {
                        suggestionsList = createSuggestionsList();
                    }
                    searchAddress(query);
                }
            });
            
            // Écouter les événements keydown pour la navigation au clavier
            addressInput.addEventListener('keydown', function(e) {
                if (!suggestionsList || suggestionsList.style.display === 'none') return;
                
                const items = suggestionsList.querySelectorAll('li');
                const currentIndex = Array.from(items).findIndex(li => li.classList.contains('selected'));
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    items.forEach(li => li.classList.remove('selected'));
                    const nextIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
                    if (items[nextIndex]) {
                        items[nextIndex].classList.add('selected');
                        items[nextIndex].scrollIntoView({ block: 'nearest' });
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    items.forEach(li => li.classList.remove('selected'));
                    const prevIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
                    if (items[prevIndex]) {
                        items[prevIndex].classList.add('selected');
                        items[prevIndex].scrollIntoView({ block: 'nearest' });
                    }
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    const selected = suggestionsList.querySelector('li.selected');
                    if (selected) {
                        selected.click();
                    }
                } else if (e.key === 'Escape') {
                    hideSuggestions();
                }
            });
            
            // Cacher les suggestions quand on clique ailleurs
            const clickOutsideHandler = function(e) {
                if (addressInput && 
                    !addressInput.contains(e.target) && 
                    (!suggestionsList || !suggestionsList.contains(e.target))) {
                    hideSuggestions();
                }
            };
            
            // Utiliser capture pour être sûr d'intercepter le clic
            document.addEventListener('click', clickOutsideHandler, true);
            
            // Nettoyer l'écouteur si l'input est supprimé
            const observer = new MutationObserver(function(mutations) {
                if (!document.body.contains(addressInput)) {
                    document.removeEventListener('click', clickOutsideHandler, true);
                    observer.disconnect();
                }
            });
            observer.observe(document.body, { childList: true, subtree: true });
            
            // Capitaliser automatiquement le nom, prénom et ville au blur
            const firstnameInput = form ? form.querySelector('input[name="firstname"]') : null;
            const lastnameInput = form ? form.querySelector('input[name="lastname"]') : null;
            
            if (firstnameInput) {
                firstnameInput.addEventListener('blur', function() {
                    this.value = capitalizeFirst(this.value);
                });
            }
            
            if (lastnameInput) {
                lastnameInput.addEventListener('blur', function() {
                    this.value = capitalizeFirst(this.value);
                });
            }
            
            if (townInput) {
                townInput.addEventListener('blur', function() {
                    this.value = capitalizeFirst(this.value);
                });
            }
        }
        
        // Initialiser pour tous les champs d'adresse trouvés
        function initializeAll() {
            const addressInputs = document.querySelectorAll('input[name="adress"]');
            console.log(`🔍 ${addressInputs.length} champ(s) d'adresse trouvé(s)`);
            
            if (addressInputs.length === 0) {
                console.warn('⚠️ Aucun champ d\'adresse trouvé');
                return;
            }
            
            addressInputs.forEach((addressInput, index) => {
                console.log(`⚙️ Initialisation du champ ${index + 1}/${addressInputs.length}`);
                setupAddressInput(addressInput);
            });
        }
        
        // Essayer plusieurs fois pour être sûr que le DOM est prêt
        function tryInit() {
            const addressInputs = document.querySelectorAll('input[name="adress"]');
            if (addressInputs.length > 0) {
                console.log(`🔍 ${addressInputs.length} champ(s) d'adresse trouvé(s) - initialisation...`);
                addressInputs.forEach((addressInput, index) => {
                    console.log(`⚙️ Initialisation du champ ${index + 1}/${addressInputs.length}`);
                    setupAddressInput(addressInput);
                });
            } else {
                console.log('⏳ Aucun champ trouvé, nouvelle tentative dans 500ms...');
                setTimeout(tryInit, 500);
            }
        }
        
        // Initialiser immédiatement si le DOM est prêt, sinon attendre
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(tryInit, 100);
            });
        } else {
            // DOM déjà chargé
            setTimeout(tryInit, 100);
        }
        
        // Réessayer aussi après un délai plus long au cas où les formulaires sont chargés dynamiquement
        setTimeout(tryInit, 1000);
        setTimeout(tryInit, 2000);
    }

    /**
     * Expose certaines fonctions globalement si nécessaire
     */
    window.showNotification = showNotification;

})();


