using System;
using System.Collections.Generic;
using System.IO;
using System.Text.Json;

namespace Portal.Helper
{

    public class DashboardDataGenerator
    {
        public static void GenerateJson(string outputPath)
        {
            var dashboardData = new
            {
                filters = new
                {
                    month = "April",
                    sales = "Sales A",
                    region = "West",
                    channel = "Online",
                    product = "EV Charger A",
                    stacked = true
                },
                summary = new
                {
                    lead = 120,
                    target = 150,
                    qualified = 80,
                    dealClosed = 45,
                    activityToday = 17
                },
                leadStages = new Dictionary<string, int>
            {
                { "Lead", 40 },
                { "Qualified", 20 },
                { "Survey", 15 },
                { "Negotiation", 10 },
                { "Win", 8 },
                { "Lost", 7 }
            },
                leadTrend8Weeks = CreateWeeklyTrend(),
                activityWeeklyBySales = CreateSalesWeeklyData(),
                activityThisWeekPie = new Dictionary<string, int>
            {
                { "Sales A", 20 },
                { "Sales B", 18 },
                { "Sales C", 21 },
                { "Sales D", 15 },
                { "Sales E", 12 }
            },
                activityPlan = new
                {
                    total = 120,
                    meeting = 50,
                    call = 40,
                    email = 20,
                    proposal = 10
                },
                taskDetails = new[]
                {
                new
                {
                    title = "Meeting with ABC Corp",
                    dueDate = DateTime.Today.ToString("yyyy-MM-dd"),
                    status = "Pending",
                    assignedTo = "Sales A",
                    channel = "Online",
                    region = "West",
                    product = "EV Charger A"
                }
            }
            };

            var jsonString = JsonSerializer.Serialize(dashboardData, new JsonSerializerOptions { WriteIndented = true });
            File.WriteAllText(outputPath, jsonString);
        }

        static List<Dictionary<string, object>> CreateWeeklyTrend()
        {
            var result = new List<Dictionary<string, object>>();
            for (int i = 0; i < 8; i++)
            {
                result.Add(new Dictionary<string, object>
            {
                { "week", $"W{i+1}" },
                { "Lead", 10+i },
                { "Qualified", 6+i },
                { "Survey", 4+i },
                { "Negotiation", 2+i },
                { "Win", 1+i },
                { "Lost", i }
            });
            }
            return result;
        }

        static List<object> CreateSalesWeeklyData()
        {
            var result = new List<object>();
            for (int i = 0; i < 3; i++)
            {
                result.Add(new
                {
                    sales = $"Sales {(char)(65 + i)}",
                    region = "West",
                    product = $"EV Charger {(char)(65 + (i % 2))}",
                    weeks = new Dictionary<string, int>
                {
                    { "W1", 10+i },
                    { "W2", 11+i },
                    { "W3", 12+i },
                    { "W4", 13+i }
                }
                });
            }
            return result;
        }
    }

}
