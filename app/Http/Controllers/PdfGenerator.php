<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Contact;
use App\Models\Vente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PdfGenerator extends Controller
{
    public function listeClents(){

        $title = 'Liste des clients ';

        $clients = Contact::where('type','Client')->orWhere('type', 'Client/Fournisseur')->orderBy('id', 'DESC')->get();
                  
        $pdf = Pdf::loadView('pdf.liste-clients', compact('title','clients'))->setOptions(['defaultFont' => 'sans-serif']);
     
        return $pdf->stream();


    }

    public function grandLivreClient(Contact $contact, Request $request)
    {
        // Initialiser le tableau viewData
        $viewData = [];

        // Titre avec le nom du client
        $viewData['title'] = $contact->nom;

        // Récupérer tous les contacts de type "Client" ou "Client/Fournisseur"
        $contacts = Contact::where('type', 'Client')
                                    ->orWhere('type', 'Client/Fournisseur')
                                    ->orWhere('type', 'Marketeur')
                                    ->orderBy('id', 'DESC')
                                    ->get();

        // Récupérer toutes les commandes du client
        $commandes = Commande::where('client_id', $contact->id)
                                        ->orderBy('id', 'DESC')
                                        ->get();

        // Récupérer toutes les ventes associées aux commandes du client
        $ventes = Vente::whereIn('commande_id', $commandes->pluck('id'))
                                ->orderBy('id', 'DESC')
                                ->get();

        // Détails des produits vendus au client
        $ventes_produit = DB::table('ventes')
                                        ->join('articles', 'ventes.article_id', '=', 'articles.id')
                                        ->join('unites', 'articles.unite_id', '=', 'unites.id')
                                        ->select(
                                            'articles.id',
                                            'articles.designation',
                                            'articles.solde',
                                            'articles.prix',
                                            'unites.nom',
                                            DB::raw('SUM(ventes.quantite) as quantite_tot'),
                                            DB::raw('SUM(ventes.bonus) as bonus_tot')
                                        )
                                        ->whereIn('ventes.commande_id', $commandes->pluck('id'))
                                        ->groupBy(
                                            'articles.id',
                                            'articles.designation',
                                            'articles.solde',
                                            'articles.prix',
                                            'unites.nom'
                                        )
                                        ->get();

        // Calculer le total des ventes (somme des prix totaux des ventes du client)
        $tot_ventes = Vente::whereIn('commande_id', $commandes->pluck('id'))
                                    ->sum('prix_tot');

        $tot_paye =  Commande::where('client_id', $contact->id)->sum('montant_paye');

        // Générer le PDF avec les données récupérées
        $pdf = Pdf::loadView('pdf.grandlivre-clients', compact('tot_ventes', 'tot_paye', 'ventes_produit', 'ventes', 'commandes', 'contact'))->setOptions(['defaultFont' => 'sans-serif']);

        // Retourner le PDF
        return $pdf->stream();
    }

}
