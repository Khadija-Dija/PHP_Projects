$("#datatable").dataTable({
  oLanguage: {
    sLengthMenu: "Afficher _MENU_ enregistrements",
    sSearch: "Recherche",
    sInfo: "Total d'enregistrements (_END_ / _TOTAL_)",
    oPaginate: {
      sNext: "Suivant",
      sPrevious: "Précédent",
    },
  },
  lengthMenu: [
    [10, 25, 50, -1],
    [10, 25, 50, "Tous"],
  ], // Spécifie les options de longueur du menu
  pageLength: 5, // Spécifie le nombre de lignes par page par défaut
});
