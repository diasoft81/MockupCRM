using Microsoft.AspNetCore.Components.Web;
using Microsoft.AspNetCore.Components.WebAssembly.Hosting;
using Serilog;
using Web.States;
using Portal;

var builder = WebAssemblyHostBuilder.CreateDefault(args);
builder.RootComponents.Add<App>("#app");
builder.RootComponents.Add<HeadOutlet>("head::after");

Console.WriteLine("Start registering service...");
try
{
    await CoreNET.Lib.ServiceContainer.RegisterServices(builder.Services, builder.HostEnvironment.BaseAddress, builder.HostEnvironment.Environment);
}
catch (Exception ex)
{
    Console.WriteLine($"Error register service from CoreNET.Lib in {builder.HostEnvironment.Environment} because: " + ex.Message);
}
try
{
    CoreNET.Blazor.Shared.ServiceContainer.RegisterServices(builder.Services, builder.HostEnvironment.BaseAddress, builder.HostEnvironment.Environment);
}
catch (Exception ex)
{
    Console.WriteLine($"Error register service from CoreNET.Blazor.Shared in {builder.HostEnvironment.Environment} because: " + ex.Message);
}

builder.Services.AddSingleton<SessionStatesPortal>();


//Log.Logger = new LoggerConfiguration()
//    .MinimumLevel.Verbose()
//    .WriteTo.BrowserConsole()
//    .CreateLogger();

await builder.Build().RunAsync();

