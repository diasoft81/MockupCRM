using CoreNET.Lib.Models;
using CoreNET.Lib.Services;
using CoreNET.Lib;
using CoreNET.Lib.Interfaces;
using CoreNET.Lib.Views;
using Blazored.LocalStorage;
using Newtonsoft.Json;
using Microsoft.AspNetCore.Components;


namespace Web.States
{
    public class SessionStatesPortal
    {
        public TAppPortal ModeApp { get; set; } = TAppPortal.Portal_User;

        public NavigationManager NavigationManager { get; set; }
        public ICard CurrentCard { get; set; }
        public string IdCard { get; set; }
        public string URLCard { get; set; }
        public string PreviousRouteOfComCard { get; set; }
        public Coordinates SelectedCordinates { get; set; }
        public List<Marker> Markers { get; set; }

        public SessionStatesPortal(NavigationManager _navigation)
        {
            NavigationManager = _navigation;
        }
        
    }

    public enum TAppPortal
    {
        Portal_User = 0,
        Portal_Admin = 1,
    }
}
