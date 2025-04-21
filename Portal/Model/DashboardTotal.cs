namespace Portal.Model
{
    using System;
    using System.Collections.Generic;
    using System.Text.Json.Serialization;

    public class DashboardData
    {
        [JsonPropertyName("filters")]
        public Filters Filters { get; set; }

        [JsonPropertyName("summary")]
        public Summary Summary { get; set; }

        [JsonPropertyName("leadStages")]
        public Dictionary<string, int> LeadStages { get; set; }

        [JsonPropertyName("leadTrend8Weeks")]
        public List<LeadTrendItem> LeadTrend8Weeks { get; set; }

        [JsonPropertyName("activityWeeklyBySales")]
        public List<ActivityBySales> ActivityWeeklyBySales { get; set; }

        [JsonPropertyName("activityThisWeekPie")]
        public Dictionary<string, int> ActivityThisWeekPie { get; set; }

        [JsonPropertyName("activityPlan")]
        public ActivityPlan ActivityPlan { get; set; }

        [JsonPropertyName("taskDetails")]
        public List<TaskDetail> TaskDetails { get; set; }
    }

    public class Filters
    {
        [JsonPropertyName("month")]
        public string Month { get; set; }

        [JsonPropertyName("sales")]
        public string Sales { get; set; }

        [JsonPropertyName("region")]
        public string Region { get; set; }

        [JsonPropertyName("channel")]
        public string Channel { get; set; }

        [JsonPropertyName("product")]
        public string Product { get; set; }

        [JsonPropertyName("stacked")]
        public bool Stacked { get; set; }
    }

    public class Summary
    {
        [JsonPropertyName("lead")]
        public int Lead { get; set; }

        [JsonPropertyName("target")]
        public int Target { get; set; }

        [JsonPropertyName("qualified")]
        public int Qualified { get; set; }

        [JsonPropertyName("dealClosed")]
        public int DealClosed { get; set; }

        [JsonPropertyName("activityToday")]
        public int ActivityToday { get; set; }
    }

    public class LeadTrendItem
    {
        [JsonPropertyName("week")]
        public string Week { get; set; }

        [JsonPropertyName("Total")]
        public int Total { get; set; }
        [JsonPropertyName("Lead")]
        public int Lead { get; set; }

        [JsonPropertyName("Qualified")]
        public int Qualified { get; set; }

        [JsonPropertyName("Survey")]
        public int Survey { get; set; }

        [JsonPropertyName("Negotiation")]
        public int Negotiation { get; set; }

        [JsonPropertyName("Win")]
        public int Win { get; set; }

        [JsonPropertyName("Lost")]
        public int Lost { get; set; }
    }

    public class ActivityBySales
    {
        [JsonPropertyName("sales")]
        public string Sales { get; set; }

        [JsonPropertyName("region")]
        public string Region { get; set; }

        [JsonPropertyName("product")]
        public string Product { get; set; }

        [JsonPropertyName("weeks")]
        public Dictionary<string, int> Weeks { get; set; }
    }

    public class ActivityPlan
    {
        [JsonPropertyName("total")]
        public int Total { get; set; }

        [JsonPropertyName("meeting")]
        public int Meeting { get; set; }

        [JsonPropertyName("call")]
        public int Call { get; set; }

        [JsonPropertyName("email")]
        public int Email { get; set; }

        [JsonPropertyName("proposal")]
        public int Proposal { get; set; }
    }

    public class TaskDetail
    {
        [JsonPropertyName("title")]
        public string Title { get; set; }

        [JsonPropertyName("dueDate")]
        public DateTime DueDate { get; set; }

        [JsonPropertyName("status")]
        public string Status { get; set; }

        [JsonPropertyName("assignedTo")]
        public string AssignedTo { get; set; }

        [JsonPropertyName("channel")]
        public string Channel { get; set; }

        [JsonPropertyName("region")]
        public string Region { get; set; }

        [JsonPropertyName("product")]
        public string Product { get; set; }
    }


}
