[ApiController]
[Route("api/[controller]")]
public class DashboardDataController : ControllerBase
{
    [HttpGet]
    public IActionResult Get(
        [FromQuery] string month,
        [FromQuery] string sales,
        [FromQuery] string region,
        [FromQuery] string channel,
        [FromQuery] string product,
        [FromQuery] bool stacked = true)
    {
        // Simulasikan load data (bisa dari DB, file JSON, dsb)
        var data = new
        {
            Filters = new { month, sales, region, channel, product, stacked },
            Summary = new
            {
                Lead = 120,
                Target = 150,
                Qualified = 80,
                DealClosed = 45,
                ActivityToday = 17
            },
            PieLeadStage = new Dictionary<string, int>
            {
                ["Lead"] = 40,
                ["Qualified"] = 20,
                ["Survey"] = 15,
                ["Negotiation"] = 10,
                ["Win"] = 8,
                ["Lost"] = 7
            },
            WeeklyLeadTrend = new[]
            {
                new { Week = "W1", Lead = 10, Qualified = 6, Survey = 4 },
                new { Week = "W2", Lead = 12, Qualified = 7, Survey = 5 },
                // ... up to W8
            },
            ActivityBySales = new[]
            {
                new { Sales = "Sales A", W1 = 5, W2 = 7, W3 = 6, W4 = 8 },
                new { Sales = "Sales B", W1 = 6, W2 = 5, W3 = 7, W4 = 9 },
            },
            WeeklyActivityPie = new Dictionary<string, int>
            {
                ["Sales A"] = 12,
                ["Sales B"] = 14,
                ["Sales C"] = 10
            },
            ActivityPlan = new { Total = 120, Meeting = 50, Call = 40, Email = 20, Proposal = 10 },
            TaskDetails = new[]
            {
                new { Title = "Follow up client X", Due = "2025-04-18", Status = "Pending" },
                new { Title = "Send proposal", Due = "2025-04-19", Status = "Completed" }
            }
        };

        return Ok(data);
    }
}
