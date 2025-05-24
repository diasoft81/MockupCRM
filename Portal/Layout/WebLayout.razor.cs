using System.Text.Json;
using Microsoft.AspNetCore.Components;
using Microsoft.JSInterop;
using MudBlazor;
using CoreNET.Lib.Views;
using CoreNET.Lib.Services;
using CoreNET.Lib.States;
using CoreNET.Lib.Models.Widgets;
using CoreNET.Blazor.Shared.Helper;
using System.Threading.Tasks;

namespace Portal.Layout
{
    public partial class WebLayout
    {
        public bool? IsMobile { get; private set; }
        public bool IsLayoutLoading { get; private set; } = false;
        public bool IsLayoutReady { get; private set; } = false;

        private bool _drawerOpen = false;
        public bool drawerOpen
        {
            get
            {
                if (AppState != null) _drawerOpen = AppState.DrawerOpen;
                return _drawerOpen;
            }
            set
            {
                if (AppState != null)
                {
                    AppState.DrawerOpen = value;
                }
                _drawerOpen = value;
            }
        }
        //AppState.DrawerOpen = true;

        private ThemeStyle SelectedThemeStyle => AppState.SelectedThemeStyle;

        private bool _isDarkMode = false;
        private string currentRoute;
        private LoginStored loginStored;

        private MudTheme? _theme = null;

        private WidgetMainParams? pars;
        private RenderFragment? topBar;
        private RenderFragment? leftMenu;

        protected override async Task OnInitializedAsync()
        {
            await base.OnInitializedAsync();

            AppState.ProjectModel = await AppState.LoadProjectContent(string.Empty, string.Empty);

            IsLayoutLoading = true;
            IsMobile = await JSRuntime.InvokeAsync<bool>("isMobile");
            _isDarkMode = await LocalStorage.IsDarkMode();
            _theme = ThemesHelper.GetTheme();

            pars = new WidgetMainParams(AppSettings) { FixedProject = true, AlwaysShowAppTitle = true };
            if (WidgetService != null && WidgetService.WidgetList != null && WidgetService.WidgetList.Count > 0)
            {
                topBar = WidgetService.GetWidgetAppBar(pars, EventCallback.Factory.Create<object>(this, EventCallBack));
                leftMenu = WidgetService.GetWidgetAppDraw(pars, EventCallback.Factory.Create<object>(this, EventCallBack));
            }

            currentRoute = Navigation.Uri; // Mendapatkan URL lengkap
            currentRoute = Navigation.ToBaseRelativePath(Navigation.Uri); // Mendapatkan hanya path relatif

            loginStored = await Session.IsLoginStored(LocalStorage);
            if (pars != null) pars.VisibleDrawerButton = loginStored.IsLoggedIn == true;

            IsLayoutReady = true;
#if DEBUG
            Console.WriteLine($"Current route={currentRoute}");
#endif
            IsLayoutLoading = false;
        }
        protected override async Task OnParametersSetAsync()
        {
            await base.OnParametersSetAsync();
        }
        protected override bool ShouldRender() => true;
        private void EventCallBack(object response)
        {
            IsLayoutReady = false;
            drawerOpen = AppState.DrawerOpen;
#if DEBUG
            Console.WriteLine($"Drawer Open: {drawerOpen}");
#endif
            OnRefreshLayout.TriggerRefresh();
            IsLayoutLoading = false;
            IsLayoutReady = true;
            //await OnInitializedAsync();
            //await InvokeAsync(StateHasChanged);

        }

        private async Task DrawerToggle()
        {
            IsLayoutReady = true;
            AppState.DrawerOpen = !AppState.DrawerOpen;
            drawerOpen = AppState.DrawerOpen;
            //await OnInitializedAsync();//Make error!
            await InvokeAsync(StateHasChanged);
        }
    }
}